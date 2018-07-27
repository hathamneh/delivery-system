<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property double base_weight
 * @property double charge_per_unit
 * @property double extra_fees_per_unit
 */
class Zone extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'base_weight',
        'charge_per_unit',
        'extra_fees_per_unit',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function customizedClients()
    {
        return $this->belongsToMany(Client::class)->withPivot('base_weight','charge_per_unit','extra_fees_per_unit');
    }

    public function couriers()
    {
        return $this->hasMany(Courier::class);
    }


    /**
     * @param int $accountNumber
     * @return mixed
     */
    public function baseWeightFor(int $accountNumber)
    {
        $client = $this->customizedClients()->find($accountNumber);
        return !is_null($client) ? $client->pivot->base_weight : $this->base_weight;
    }

    /**
     * @param int $accountNumber
     * @return mixed
     */
    public function chargePerUnitFor(int $accountNumber)
    {
        $client = $this->customizedClients()->find($accountNumber);
        return !is_null($client) ? $client->pivot->charge_per_unit : $this->charge_per_unit;
    }

    /**
     * @param int $accountNumber
     * @return mixed
     */
    public function extraFeesPerUnitFor(int $accountNumber)
    {
        $client = $this->customizedClients()->find($accountNumber);
        return !is_null($client) ? $client->pivot->extra_fees_per_unit : $this->extra_fees_per_unit;
    }
}
