<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReturnedShipment extends Shipment
{

    protected $table = "shipments";
    protected $waybill_prefix = "2";
    protected $waybill_type = "returned";
    /**
     * model life cycle event listeners
     */
    public static function boot(){
        parent::boot();

        static::creating(function ($instance){
            $instance->type = "returned";
        });

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'returned');
        });
    }

    public static function createFrom(Shipment $returned, $overrides = [])
    {
        $shipment = new static;
        $shipment->waybill = $shipment->generateNextWaybill();
        $shipment->address()->associate($returned->address);
        $shipment->client()->associate($returned->client);
        $shipment->courier()->associate($returned->courier);
        $shipment->status()->associate(Status::name('returned')->first());

        $shipment->delivery_date = $overrides['delivery_date'] ?? $returned->delivery_date;

        $shipment->address_sub_text = $overrides['address_sub_text'] ?? $returned->client->address_pickup_text;
        $shipment->address_maps_link = $overrides['address_maps_link'] ?? $returned->client->address_pickup_maps;
        $shipment->consignee_name = $overrides['consignee_name'] ??  $returned->client->name;
        $shipment->phone_number = $overrides['phone_number'] ?? $returned->client->phone_number;

        $shipment->package_weight = $overrides['package_weight'] ?? $returned->package_weight;
        $shipment->service_type = $overrides['service_type'] ?? "nextday";

        $shipment->internal_notes = $overrides['internal_notes'] ?? "[ORIGINAL SHIPMENT NOTES]<br>".$returned->internal_notes."<br>[END ORIGINAL NOTES]";
        $shipment->delivery_cost_lodger = $overrides['delivery_cost_lodger'] ?? $returned->delivery_cost_lodger;
        $shipment->status_notes = $overrides['status_notes'] ?? $returned->status_notes;

        $shipment->shipment_value = $overrides['shipment_value'] ?? $returned->shipment_value;
        $shipment->gatherPriceInformation();

        $shipment->returnedFrom()->associate($returned);

        $shipment->push();

        return $shipment;
    }

    public function returnedFrom()
    {
        return $this->belongsTo(Shipment::class, "returned_from", "shipment_id");
    }
}
