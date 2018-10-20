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

    public function getPickupsAttribute()
    {
        return $this->pickups()->get();
    }

    public static function findOrCreateByNationalId($nationalId, array $attributes)
    {
        /** @var static $guest */
        $guest = self::firstOrNew(['national_id' => $nationalId]);
        $guest->fill($attributes);
        $guest->save();
        return $guest;
    }

}
