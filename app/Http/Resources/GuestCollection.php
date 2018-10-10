<?php

namespace App\Http\Resources;

use App\Guest;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class GuestCollection
 * @package App\Http\Resources
 *
 * @mixin Guest
 */
class GuestCollection extends JsonResource
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
            'id'           => $this->id,
            'trade_name'   => $this->trade_name,
            'phone_number' => $this->phone_number,
            'country'      => $this->country,
            'city'         => $this->city,
            'national_id'  => $this->national_id,
        ];
    }
}
