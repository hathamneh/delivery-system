<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientSuggestCollection extends JsonResource
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
            'id' => $this->account_number,
            'text' => $this->account_number,
            'name' => $this->name,
            'trade_name' => $this->trade_name,
            'phone_number' => $this->phone_number,
            'address_pickup_text' => $this->address_pickup_text,
            'address_pickup_maps' => $this->address_pickup_maps,
            'zone' => $this->zone->name,
        ];
    }
}
