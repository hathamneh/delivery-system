<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientChargedFor;
use App\Http\Requests\StoreClientRequest;
use App\Shipment;
use App\Status;
use App\User;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Client::class);

        $clients = Client::all();
        return view('clients.index', [
            'clients'   => $clients,
            'pageTitle' => trans('client.label')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Client::class);

        $countries = \Countries::lookup();
        $zones = Zone::all();

        return view('clients.create')->with([
            'countries'           => $countries,
            'zones'               => $zones,
            'next_account_number' => Client::nextAccountNumber(),
            'pageTitle'           => trans('client.create')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $client = new Client;

        $this->savePersonalData($request, $client);
        $this->saveAccountingData($request, $client);
        $client->push();
        $this->chargeFor($client, $request);
        $client->createUser();
        $client->uploadAttachments($request->file('client_files'));

        return redirect()->route('clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @param string $tab
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, Request $request, $tab = "statistics")
    {
        $data = [
            'client'         => $client,
            'tab'            => $tab,
            'pageTitle'      => $client->trade_name,
            'shipmentsCount' => $client->shipments()->count(),
            'pickupsCount'   => $client->pickups()->count(),
        ];

        switch ($tab) {
            case 'statistics':
                $this->appendStatsData($data, $client, $request);
                break;
            case 'shipments':
                $data['shipments'] = $client->shipments()->filtered();
                break;
            case 'pickups':
                $data['pickups'] = $client->pickups()->get();
                $data['startDate'] = $data['endDate'] = false;
                break;
            case 'zones':
                $data['zones'] = Zone::all();
                $data['customZones'] = $client->customZones()->get();
                break;
            case 'edit':
                $data['countries'] = \Countries::lookup();
                $data['zones'] = Zone::all();
                break;
        }
        return view('clients.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @param $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, $section = 'personal')
    {
        $data = [
            'client'         => $client,
            'countries'      => \Countries::lookup(),
            'zones'          => Zone::all(),
            'pageTitle'      => trans('client.edit') . ' ' . $client->trade_name,
            'tab'            => 'edit',
            'section'        => $section,
            'shipmentsCount' => $client->shipments()->count(),
            'pickupsCount'   => $client->pickups()->count(),
        ];
        return view('clients.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Client $client
     * @param string $section
     * @return Response
     */
    public function update(Request $request, Client $client)
    {
        $section = $request->get('section');
        switch ($section) {
            case 'personal':
                $this->savePersonalData($request, $client);
                $client->push();
                break;
            case 'accounting':
                $this->saveAccountingData($request, $client);
                $this->chargeFor($client, $request);
                $client->push();
                break;
            case 'attachments':
                $request->validate([
                    'client_files.*' => 'required|file|max:5000|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xsl,xslx',
                ],
                    [
                        'max'   => "The file cannot be greater than 5 MB",
                        'mimes' => "The file must be of type :values"
                    ]);
                if ($request->hasFile('client_files'))
                    $client->uploadAttachments($request->file('client_files'));
                break;
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Client $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        try {
            $client->delete();
        } catch (\Exception $ex) {

        }
        return redirect()->route('clients.index')->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans("client.deleted")
            ]
        ]);
    }


    public function savePersonalData(Request $request, Client &$client)
    {
        $client->trade_name = $request->trade_name;
        $client->national_id = $request->national_id;
        $client->password = User::generatePassword();
        $client->name = $request->name;
        $client->phone_number = $request->get('phone_number', null);
        $client->email = $request->get('email', null);
        $client->address = $request->get('address', []);
        $client->urls = $request->get('urls', []);
    }

    public function saveAccountingData(Request $request, Client &$client)
    {
        $client->zone()->associate(Zone::findOrFail($request->get('zone_id', 0)));
        $client->pickup_address = $request->get('pickup_address', []);
        $client->sector = $request->get('sector', null);
        $client->category = $request->get('category', null);
        $client->bank = $request->get('bank', []);
        $client->min_delivery_cost = $request->get('min_delivery_cost', 0);
        $client->max_returned_shipments = $request->get('max_returned_shipments', 0);
    }


    private function chargeFor(Client $client, Request $request)
    {
        if (is_array($chargedForItems = $request->get('chargedFor'))) {
            foreach ($chargedForItems as $statusName => $item) {
                if (!is_array($item) || !empty(array_diff(['enabled', 'value', 'type'], array_keys($item)))) continue;
                $status = Status::name($statusName)->first();
                if (is_null($status)) continue;
                $chargedFor = new ClientChargedFor;
                $chargedFor->status()->associate($status);
                $chargedFor->enabled = $item['enabled'] == "on";
                $chargedFor->type = $item['type'];
                $chargedFor->value = $item['value'];
                $chargedFor->client()->associate($client);
                $chargedFor->save();
            }
        }
    }

    protected function appendStatsData(array &$data, Client $client, Request $request)
    {
        $start_time = strtotime("-29 days");
        $end_time = time();
        $start = $request->get('start', $start_time);
        $end = $request->get('end', $end_time);
        $data['startDate'] = $start;
        $data['endDate'] = $end;
        try {
            $begin = Carbon::createFromTimestamp($request->get('start', $start));
            $until = Carbon::createFromTimestamp($request->get('end', $end));
            $data['statistics'] = $client->statistics($begin, $until);
        } catch (\Exception $ex) {
            $begin = Carbon::createFromTimestamp($start_time);
            $until = Carbon::createFromTimestamp($end_time);
            $data['statistics'] = $client->statistics($begin, $until);
            $data['alert'] = (object)[
                'type' => 'danger',
                'msg'  => "Date range provided is invalid"
            ];
        }
        $data['daterange'] = $begin->toFormattedDateString() . ' - ' . $until->toFormattedDateString();
    }
}
