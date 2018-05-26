<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class Client extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
        'facebook_url',
        'sector',
        'category',
        'bank_name',
        'bank_branch',
        'bank_client_name',
        'bank_iban',
    ];

    public function getAddressAttribute()
    {
        return [
            'address_country' => $this->address_country,
            'address_city'    => $this->address_city,
            'address_sub'     => $this->address_sub,
            'address_maps'    => $this->address_maps,
        ];
    }

    public function getBankAttribute()
    {
        return [
            'bank_name'        => $this->bank_name,
            'bank_branch'      => $this->bank_branch,
            'bank_client_name' => $this->bank_client_name,
            'bank_iban'        => $this->bank_iban,
        ];
    }

    public function user()
    {
        return $this->hasOne(User::class, 'identifier', 'account_number');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
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
}
