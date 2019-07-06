<?php

namespace App\Http\Resources;

use App\Shipment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ShipmentSuggestCollection
 * @package App\Http\Resources
 *
 * @mixin Shipment
 */
class ShipmentSuggestCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->waybill,
            'text' => $this->waybill,
            'client' => $this->is_guest ? $this->guest->trade_name : $this->client->name,
            'address' => $this->address_sub_text,
            'delivery_date' => $this->delivery_date->format("d-m-Y"),
        ];
    }
}
