<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'client' => $this->client->name,
            'address' => $this->address_sub_text,
            'delivery_date' => $this->delivery_date->format("d-m-Y"),
        ];
    }
}
