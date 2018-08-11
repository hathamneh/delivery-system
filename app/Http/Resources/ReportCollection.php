<?php

namespace App\Http\Resources;

use App\Shipment;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportCollection extends ResourceCollection
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
            "draw"            => $request->get('draw'),
            "recordsTotal"    => Shipment::count(),
            "recordsFiltered" => $this->total(),
            "data"            => ShipmentCollection::collection($this->collection),
        ];
    }

    public function with($request)
    {
        return [];
    }
}
