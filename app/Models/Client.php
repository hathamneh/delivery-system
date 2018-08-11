<?php

namespace App;


use App\Interfaces\Accountable;
use App\Traits\ClientAccounting;
use App\Traits\HasAttachmentsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * @property int account_number
 * @property string name
 * @property string trade_name
 * @property string password
 * @property string phone_number
 * @property string email
 *
 * @property User user
 * @property Zone zone
 *
 * @property string category
 * @property string sector
 *
 * @property string address_pickup_text
 * @property string address_pickup_maps
 *
 * @property string address_country
 * @property string address_city
 * @property string address_sub
 * @property string address_maps
 *
 * @property string bank_name
 * @property string bank_account_number
 * @property string bank_holder_name
 * @property string bank_iban
 *
 * @property mixed url_instagram
 * @property mixed url_website
 * @property mixed url_facebook
 * @property object|array address
 * @property object|array pickup_address
 * @property object|array bank
 * @property object|array urls
 */
class Client extends Model implements Accountable
{
    use SoftDeletes, HasAttachmentsTrait;
    use ClientAccounting;

    protected $dates = ['deleted_at'];

    protected $primaryKey = "account_number";

    protected $folderToUpload = 'clients';

    protected $fillable = [
        'account_number',
        'name',
        'trade_name',
        'password',
        'phone_number',
        'email',
        'address_country',
        'address_city',
        'address_sub',
        'address_maps',
        'address_pickup_text',
        'address_pickup_maps',
        'url_facebook',
        'url_instagram',
        'url_website',
        'sector',
        'category',
        'bank_name',
        'bank_account_number',
        'bank_holder_name',
        'bank_iban',
    ];

    public function getAddressAttribute()
    {
        return (object)[
            'country' => $this->address_country,
            'city'    => $this->address_city,
            'sub'     => $this->address_sub,
            'maps'    => $this->address_maps,
        ];
    }

    public function getPickupAddressAttribute()
    {
        return (object)[
            'text' => $this->address_pickup_text,
            'maps' => $this->address_pickup_maps,
        ];
    }

    public function getBankAttribute()
    {
        return (object)[
            'name'           => $this->bank_name,
            'account_number' => $this->bank_account_number,
            'holder_name'    => $this->bank_holder_name,
            'iban'           => $this->bank_iban,
        ];
    }

    public function getUrlsAttribute()
    {
        return (object)[
            'website'   => $this->url_website,
            'facebook'  => $this->url_facebook,
            'instagram' => $this->url_instagram,
        ];
    }

    public function setAddressAttribute($val)
    {
        $this->address_country = $val['country'] ?? $this->address_country;
        $this->address_city = $val['city'] ?? $this->address_city;
        $this->address_sub = $val['sub'] ?? $this->address_sub;
        $this->address_maps = $val['maps'] ?? $this->address_maps;
    }

    public function setPickupAddressAttribute($val)
    {
        $this->address_pickup_text = $val['text'] ?? $this->address_pickup_text;
        $this->address_pickup_maps = $val['maps'] ?? $this->address_pickup_maps;
    }

    public function setBankAttribute($val)
    {
        $this->bank_name = $val['name'] ?? $this->bank_name;
        $this->bank_account_number = $val['account_number'] ?? $this->bank_account_number;
        $this->bank_holder_name = $val['holder_name'] ?? $this->bank_holder_name;
        $this->bank_iban = $val['iban'] ?? $this->bank_iban;
    }

    public function setUrlsAttribute($val)
    {
        $this->url_website = $val['website'] ?? $this->url_website;
        $this->url_facebook = $val['facebook'] ?? $this->url_facebook;
        $this->url_instagram = $val['instagram'] ?? $this->url_instagram;
    }


    public function createUser()
    {
        if (!is_null($this->user)) return $this->user;

        $user_template = UserTemplate::where('name', 'client')->first();
        if(is_null($user_template)) UserTemplate::default()->first();

        $user = new User;
        $user->username = $this->trade_name;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);
        $user->template()->associate($user_template);
        $user->client()->associate($this);
        $user->save();

        return $user;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'identifier', 'account_number');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function pickups()
    {
        return $this->hasMany(Pickup::class, 'client_account_number','account_number');
    }

    public function charged_for()
    {
        return $this->hasMany(ClientChargedFor::class);
    }


    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'client_account_number', 'account_number');
    }

    public function customServices()
    {
        return $this->belongsToMany(Service::class)->withPivot('price');
    }

    public function customZones()
    {
        return $this->belongsToMany(Zone::class)->withPivot('base_weight', 'charge_per_unit', 'extra_fees_per_unit');
    }

    public function customAddresses()
    {
        return $this->belongsToMany(Address::class)->withPivot('sameday_price', 'scheduled_price');
    }

    public function resetAlert()
    {
        return $this->update(['alerted', false]);
    }

    public function pickupFeesPaid()
    {
        return $this->update(['is_fees_paid' => true]);
    }

    public static function findByAccNum(int $account_number, bool $withTrashed = false): Client
    {
        if ($withTrashed)
            return self::withTrashed()->where('account_number', $account_number)->first();
        return self::where('account_number', $account_number)->first();
    }

    /**
     * @return string
     */
    public function color()
    {
        // This function reason is to return true if the client has a shipment that did not reach a dead end status ()

        /* Red Color (Money !) */
        $unpaid_orders = $this->shipments()->unpaid()->count();
        if ($unpaid_orders > 0) {
            return Config::get('constants.color.red');
        }
        /* Orange Color */
        $pending_orders = $this->shipments()->pending()->count();
        if ($pending_orders > 0) {
            return Config::get('constants.color.orange');
        }

        return Config::get('constants.color.black');
    }

    public function changePassword(string $newPass)
    {
        $this->user->fill([
            'password' => Hash::make($newPass)
        ])->save();
        $this->fill([
            'password' => $newPass
        ])->save();
    }

    public static function nextAccountNumber()
    {
        $statement = DB::select("SHOW TABLE STATUS LIKE 'clients'");
        return $statement[0]->Auto_increment;
    }


}
