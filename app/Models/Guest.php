<?php

namespace App;

use App\Interfaces\Accountable;
use App\Interfaces\CanHaveShipment;
use App\Traits\ClientAccounting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property string trade_name
 * @property string phone_number
 * @property string country
 * @property string city
 * @property string national_id
 * @property Collection[Shipments] shipments
 */
class Guest extends Model implements Accountable, CanHaveShipment
{
    use ClientAccounting;

    protected $fillable = [
        'trade_name',
        'phone_number',
        'country',
        'city',
        'national_id'
    ];

    public function shipments()
    {
        return $this->hasMany(GuestShipment::class, "client_account_number", "id");
    }

}
