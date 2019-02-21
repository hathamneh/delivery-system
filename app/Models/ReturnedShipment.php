<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReturnedShipment extends Shipment
{

    protected $table = "shipments";
    protected $waybill_prefix = "3";
    protected static $waybill_type = "returned";

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('returned', function(Builder $builder) {
            $builder->whereType(self::$waybill_type);
        });
    }

    public function returnedFrom()
    {
        return $this->belongsTo(Shipment::class, "returned_from", "id");
    }




    public static function createFrom(Shipment $returned, $overrides = [])
    {
        $shipment = new static;
        $waybill = $shipment->generateNextWaybill();
        $shipment->waybill = $waybill['waybill'];
        $shipment->waybill_index = $waybill['index'];

        $shipment->address()->associate($returned->address);

        $shipment->courier()->associate($returned->courier);
        $shipment->status()->associate(Status::name('received')->first());

        $shipment->delivery_date = $overrides['delivery_date'] ?? $returned->delivery_date;

        if($returned->is_guest) {
            $shipment->guest()->associate($returned->guest);
            $shipment->address_sub_text = $overrides['address_sub_text'] ?? $returned->guest->country . "," . $returned->guest->city;
            $shipment->address_maps_link = $overrides['address_maps_link'] ?? null;
            $shipment->consignee_name = $overrides['consignee_name'] ??  $returned->guest->trade_name;
            $shipment->phone_number = $overrides['phone_number'] ?? $returned->guest->phone_number;
        } else {
            $shipment->client()->associate($returned->client);
            $shipment->address_sub_text = $overrides['address_sub_text'] ?? $returned->client->address_pickup_text;
            $shipment->address_maps_link = $overrides['address_maps_link'] ?? $returned->client->address_pickup_maps;
            $shipment->consignee_name = $overrides['consignee_name'] ?? $returned->client->name;
            $shipment->phone_number = $overrides['phone_number'] ?? $returned->client->phone_number;
        }
        $shipment->package_weight = $overrides['package_weight'] ?? $returned->package_weight;
        $shipment->service_type = $overrides['service_type'] ?? "nextday";

        $shipment->internal_notes = $overrides['internal_notes'] ?? "[ORIGINAL SHIPMENT NOTES]<br>".$returned->internal_notes."<br>[END ORIGINAL NOTES]";
        $shipment->delivery_cost_lodger = $overrides['delivery_cost_lodger'] ?? $returned->delivery_cost_lodger;
        $shipment->status_notes = $overrides['status_notes'] ?? $returned->status_notes;

        $shipment->pieces = $overrides['pieces'] ?? $returned->pieces;
        $shipment->shipment_value = $overrides['shipment_value'] ?? $returned->shipment_value;
        $shipment->gatherPriceInformation();

        $shipment->returnedFrom()->associate($returned);

        $shipment->push();

        activity()
            ->performedOn($returned)
            ->causedBy(auth()->user())
            ->log('Shipment to be returned in new waybill (' . $shipment->waybill . ')');

        activity()
            ->performedOn($shipment)
            ->causedBy(auth()->user())
            ->log('Shipment created for returning waybill (' . $returned->waybill . ')');

        return $shipment;
    }
}
