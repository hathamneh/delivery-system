<?php

namespace App;

use App\Interfaces\CanHaveShipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Service
 * @package App
 *
 * @property string name
 * @property double price
 * @property Collection shipments
 */
class Service extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function customClients()
    {
        return $this->belongsToMany(Client::class)->withPivot('price');
    }

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class);
    }

    public function shipmentsCount()
    {
        return $this->shipments->count();
    }

    public function hasShipment(Shipment $shipment)
    {
        return $this->shipments()->exists($shipment->id);
    }

    public function customFor(CanHaveShipment $client)
    {
        if ($client instanceof Client)
            return $this->customClients()->where('account_number', $client->account_number)->first() ?? false;
        return null;
    }
}
