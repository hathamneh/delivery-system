<?php

namespace App;

use App\Interfaces\CanHaveShipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

/**
 * Class Service
 * @package App
 *
 * @property int id
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
        return $this->shipments()->where('shipment_id', $shipment->id)->exists();
    }

    public function customFor(CanHaveShipment $client)
    {
        if ($client instanceof Client)
            return $this->customClients()->where('account_number', $client->account_number)->first() ?? false;
        return null;
    }

    public function getShortNameAttribute()
    {
        preg_match_all("/\(([^\(]*)\)/", $this->name, $matches);
        return $matches[1][0];
    }

    public static function routes()
    {
        Route::resource('services', "ServicesController");
    }
}
