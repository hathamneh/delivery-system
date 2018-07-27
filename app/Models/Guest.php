<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property Collection[Shipments] shipments
 */
class Guest extends Model
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
