<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Resources\ClientSuggestCollection;
use App\Http\Resources\ShipmentSuggestCollection;
use App\Http\Resources\StatusSuggestCollection;
use App\Shipment;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuggestController extends Controller
{
    public function shipments(Request $request)
    {
        $term = (int)$request->get('term');
        $shipments = Shipment::waybill($term)->get();
        if(!is_null($shipments))
            return ShipmentSuggestCollection::collection($shipments);
        return [];
    }

    public function clients(Request $request)
    {
        $term = (int)$request->get('term');
        $client = Client::where('account_number',$term)->get();
        if(!is_null($client))
            return ClientSuggestCollection::collection($client);
        return [];
    }

    public function statuses(Status $status)
    {
        $sub = $status->subStatuses()->get();

        return [
            'subStatuses' => StatusSuggestCollection::collection($sub),
            'suggestions' => $status->suggested_reasons
        ];
    }
}
