<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GuestShipment extends Shipment
{
    protected $table = "shipments";

    /**
     * model life cycle event listeners
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($instance) {
            $instance->type = "guest";
        });

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'guest');
        });
    }

    public function client()
    {
        return $this->belongsTo(Guest::class, 'client_account_number', 'id');
    }

    /**
     * @param array $clientData
     */
    public function saveClient(array $clientData)
    {
        $guest = Guest::firstOrCreate([
            'trade_name'   => $clientData['name'],
            'phone_number' => $clientData['phone_number'],
            'country'      => $clientData['country'],
            'city'         => $clientData['city'],
            'national_id'  => $clientData['national_id'],
        ]);
        $this->client()->associate($guest);
    }

}
