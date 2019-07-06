<?php

namespace App;

use App\Interfaces\Accountable;
use App\Interfaces\CanHaveShipment;
use App\Traits\ClientAccounting;
use App\Traits\PrepareAccounting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property string trade_name
 * @property string phone_number
 * @property string country
 * @property string city
 * @property string national_id
 * @property Collection[Shipments] shipments
 * @property Address address
 * @property string address_detailed
 * @mixin Builder
 */
class Guest extends Model implements Accountable, CanHaveShipment
{
    use PrepareAccounting, ClientAccounting;

    protected $fillable = [
        'trade_name',
        'phone_number',
        'country',
        'city',
        'national_id',
    ];

    public function shipments()
    {
        return $this->hasMany(Shipment::class, "client_account_number", "id");
    }

    public function pickups()
    {
        return Pickup::where('client_national_id', '=', $this->national_id);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function getPickupsAttribute()
    {
        return $this->pickups()->get();
    }

    public static function findOrCreateByNationalId($nationalId, array $attributes)
    {
        /** @var static $guest */
        $guest = self::firstOrNew(['national_id' => $nationalId]);
        list('trade_name' => $trade_name,
            'phone_number' => $phone_number,
            'country' => $country,
            'city' => $city,
            'address_id' => $address_id,
            'address_detailed' => $address_detailed,
            ) = $attributes;
        $guest->trade_name = $trade_name;
        $guest->phone_number = $phone_number;
        $guest->country = $country;
        $guest->city = $city;
        $guest->address_detailed = $address_detailed;
        $guest->address()->associate($address_id);
        $guest->save();
        return $guest;
    }

}
