<?php

namespace App\Http\Controllers;

use App\Client;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ClientServicesController extends Controller
{

    public function __construct()
    {
        /** @var Client $client */
        $client = Client::find(\request('client'));
        View::share([
            "pageTitle"   => "{$client->trade_name} - Custom Services",
            'tab'         => 'services',
            'client'      => $client,
            'shipmentsCount' => $client->shipments()->count(),
            'pickupsCount'   => $client->pickups()->count(),
            'services'       => Service::all(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        return view('clients.show', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Client $client
     * @param Service $service
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client, Service $service)
    {
        $newPrice = $request->get('price', false);
        if($newPrice) {
            $client->customServices()->attach($service->id, ['price' => $newPrice]);
        }
        return redirect()->route('clients.services.index', [$client]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
}
