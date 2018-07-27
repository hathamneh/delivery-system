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

    public static function createFrom(Shipment $returned)
    {
        $data = [
            'waybill',
            'delivery_date',
            'address_sub_text',
            'address_maps_link',
            'consignee_name',
            'phone_number',
            'package_weight',
            'service_type',
            'internal_notes',
            'external_notes',
            'delivery_cost_lodger',
            'shipment_value',
            'status_notes',
            'price_of_address',
            'base_weight_of_zone',
            'charge_per_unit_of_zone',
            'extra_fees_per_unit_of_zone',
            'actual_paid_by_consignee',
            'courier_cashed',
            'client_paid',
        ];
        $shipment = new static;
        $shipment->waybill = $shipment->generateNextWaybill();
        $shipment->delivery_date = $returned->delivery_date;
        $shipment->address_sub_text = $returned->client->address_pickup_text;
    }
}
