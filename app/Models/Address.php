<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string name
 * @property double sameday_price
 * @property double scheduled_price
 * @property Zone zone
 */
class Address extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'sameday_price',
        'scheduled_price',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function customizedClients()
    {
        return $this
            ->belongsToMany(Client::class, 'client_address', 'address_id', 'client_account_number')
            ->withPivot('sameday_price', 'scheduled_price');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    /**
     * @param int $accountNumber
     * @return mixed
     */
    public function sameDayPriceFor(int $accountNumber)
    {
        $client = $this->customizedClients()->find($accountNumber);
        return !is_null($client) ? $client->pivot->sameday_price : $this->sameday_price;
    }

    /**
     * @param int $accountNumber
     * @return mixed
     */
    public function scheduledPriceFor(int $accountNumber)
    {
        $client = $this->customizedClients()->find($accountNumber);
        return !is_null($client) ? $client->pivot->scheduled_price : $this->scheduled_price;
    }

    public function identifiableName()
    {
        return $this->name;
    }
}
