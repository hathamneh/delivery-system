<?php

namespace App;

use App\Interfaces\CanHaveShipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property Collection[Shipments] shipments
 */
class Guest extends Model implements CanHaveShipment
{
    protected $fillable = [
        'trade_name',
        'phone_number',
        'country',
        'city',
    ];

    public function shipments()
    {
        return $this->hasMany(GuestShipment::class, "client_account_number", "id");
    }
}
