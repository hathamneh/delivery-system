<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                       => $this->id,
            'client_account_number'    => $this->client_account_number,
            'status'                   => [
                'display' => trans("shipment.statuses.{$this->status->name}.name"),
                "value"   => $this->status_id
            ],
            'waybill'                  => $this->waybill,
            'courier'                  => $this->courier->name,
            'delivery_date'            => [
                "display" => $this->delivery_date->toFormattedDateString(),
                "value"   => $this->delivery_date->timestamp,
            ],
            'address'                  => $this->address->name,
            'phone_number'             => $this->phone_number,
            'delivery_cost'            => $this->delivery_cost,
            'shipment_value'           => $this->shipment_value,
            'actual_paid_by_consignee' => $this->actual_paid_by_consignee,
            'courier_cashed'           => $this->courier_cashed,
            'client_paid'              => $this->client_paid,
        ];
    }

    public function with($request)
    {
        return [
            "test" => "hello"
        ];
    }
}
