<?php

namespace App\Http\Controllers;

use App\Client;
use App\CustomZone;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ClientZonesController extends Controller
{

    public function __construct()
    {
        /** @var Client $client */
        $client = Client::find(\request('client'));
        View::share([
            "pageTitle"   => "{$client->trade_name} - Custom Zones",
            'tab'         => 'zones',
            'client'      => $client,
            'shipmentsCount' => $client->shipments()->count(),
            'pickupsCount'   => $client->pickups()->count(),
            'zones'       => Zone::whereNotIn('id', $client->customZones()->pluck('zone_id'))->get(),
            'customZones' => $client->customZones()->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Client $client
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clients.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Client $client
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Client $client, Request $request)
    {
        $zone = Zone::find($request->get('zone_id'));
        $customZone = CustomZone::createFromZone($zone, $client);
        $customZone->save();
        return redirect()->route('clients.zones.show', ['client' => $client, 'zone' => $customZone]);
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @param CustomZone $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, CustomZone $zone)
    {
        $data = [];
        $data['selected'] = $zone;
        $data['zoneTab'] = "props";
        return view('clients.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Client $client
     * @param CustomZone $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client, CustomZone $zone)
    {
        $request->validate([
            'base_weight'         => 'required',
            'charge_per_unit'     => 'required',
            'extra_fees_per_unit' => 'required'
        ]);
        $zone->base_weight = $request->get('base_weight');
        $zone->charge_per_unit = $request->get('charge_per_unit');
        $zone->extra_fees_per_unit = $request->get('extra_fees_per_unit');

        $zone->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
