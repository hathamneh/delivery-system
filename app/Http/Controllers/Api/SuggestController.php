<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Resources\ClientSuggestCollection;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuggestController extends Controller
{
    public function shipments()
    {
        return [
            "results" => [
                [
                    'id' => 1165165461,
                    'text' => "1165165461",
                    'client' => 'Haitham Athamneh',
                    'address' => "Amman, Jordan",
                    'delivery_date' => '12/07/2018',
                ],
                [
                    'id' => 55659999,
                    'text' => "55659999",
                    'client' => 'Haitham Athamneh',
                    'address' => "Az Zarqa, Jordan",
                    'delivery_date' => '13/07/2018',
                ],
                [
                    'id' => 8866555444,
                    'text' => "8866555444",
                    'client' => 'Ahmad Halholi',
                    'address' => "Amman, Jordan",
                    'delivery_date' => '20/07/2018',
                ],
                [
                    'id' => 33666565,
                    'text' => "33666565",
                    'client' => 'Abdullah Zaiii',
                    'address' => "Irbid, Jordan",
                    'delivery_date' => '12/07/2018',
                ],
            ]
        ];
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
            'subStatuses' => $sub,
            'suggestions' => $status->suggested_reasons
        ];
    }
}
