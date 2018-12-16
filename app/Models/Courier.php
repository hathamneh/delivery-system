<?php

namespace App;

use App\Interfaces\Accountable;
use App\Traits\CourierAccounting;
use App\Traits\HasAttachmentsTrait;
use App\Traits\PrepareAccounting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/**
 * @property int id
 * @property string name
 * @property string password
 * @property string phone_number
 * @property string address
 * @property integer category
 * @property string notes
 * @property Collection[Attachment] attachments
 * @property User user
 * @property string email
 */
class Courier extends Model implements Accountable
{
    use SoftDeletes, HasAttachmentsTrait;
    use PrepareAccounting, CourierAccounting;

    protected $dates = ['deleted_at'];

    protected $folderToUpload = "couriers";

    protected $fillable = [
        'name',
        'email',
        'password' .
        'phone_number',
        'address',
        'category',
        'notes',
    ];

    public function scopeHaveSmiley($query)
    {
        $thirtyDaysBefore = date("d-m-Y", strtotime("- 30 days"));
        $ShipmentsCountForSmiley = intval(Setting::get("promotion_requirement")->value) ?? 30;

        return $query->leftJoin('shipments', 'couriers.id', '=', 'shipments.courier_id')
            ->where('shipments.delivery_date', ">", $thirtyDaysBefore)
            ->groupBy('shipments.id')->havingRaw("count(`shipments`.`id`) > $ShipmentsCountForSmiley");
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function pickups()
    {
        return $this->hasMany(Pickup::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'identifier', 'id');
    }

    public function createUser()
    {
        if (!is_null($this->user)) return $this->user;

        $user_template = UserTemplate::where('name', 'courier')->first();
        if(is_null($user_template)) UserTemplate::default()->first();

        $user = new User;
        $user->username = str_pad($this->id,4,"0",STR_PAD_LEFT);
        $user->email = $this->email;
        $user->password = Hash::make($this->password);
        $user->template()->associate($user_template);
        $user->courier()->associate($this);
        $user->save();

        return $user;
    }

    public static function routes()
    {
        Route::resource('couriers', "CouriersController");
    }
}
