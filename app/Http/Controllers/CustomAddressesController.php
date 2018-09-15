<?php

namespace App\Http\Controllers;

use App\Address;
use App\Client;
use App\CustomAddress;
use App\CustomZone;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CustomAddressesController extends Controller
{

    public function __construct()
    {
        /** @var Client $client */
        $client = Client::find(\request('client'));
        View::share([
            "pageTitle"   => "{$client->trade_name} - Custom Zone Addresses",
            'tab'         => 'zones',
            'client'      => $client,
            'zones'       => Zone::whereNotIn('id', $client->customZones()->pluck('zone_id'))->get(),
            'customZones' => $client->customZones()->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['selected'] = CustomZone::find(\request('zone'));
        $data['zoneTab'] = "addresses";
        return view('clients.show', $data);
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
     * @param  \Illuminate\Http\Request $request
     * @param Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $address = Address::find($request->get('address'));
        $zone = CustomZone::find($request->get('customZone'));
        if (!is_null($address)) {
            $customAddress = CustomAddress::createFromAddress($address, $zone, $client);
        } else {
            $customAddress = new CustomAddress;
            $customAddress->client()->associate($client);
            $customAddress->zone()->associate($zone);
            $customAddress->name = $request->get('name', '');
        }
        $customAddress->sameday_price = $request->get('sameday_price', $customAddress->sameday_price);
        $customAddress->scheduled_price = $request->get('scheduled_price', $customAddress->scheduled_price);
        $customAddress->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomAddress $customAddress
     * @return \Illuminate\Http\Response
     */
    public function show(CustomAddress $customAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomAddress $customAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomAddress $customAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param CustomAddress $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client, CustomAddress $address)
    {
        //$customAddress = CustomAddress::findOrFail(intval($address));
        $address->sameday_price = $request->get('sameday_price', $address->sameday_price);
        $address->scheduled_price = $request->get('scheduled_price', $address->scheduled_price);
        $address->save();
        return back();
    }

    public function bulk(Request $request, Client $client)
    {
        $sameday_price = $request->get('sameday_price', false);
        $scheduled_price = $request->get('scheduled_price', false);

        $addresses = $this->parseAddresses($request->get('addresses', ''));
        foreach ($addresses as $id => $state) {
            if ($state == "new") {
                /** @var Address $address */
                $address = Address::find($id);
                /** @var CustomZone $zone */
                $zone = CustomZone::find($request->get('customZone'));
                if (!is_null($address)) {
                    $customAddress = CustomAddress::createFromAddress($address, $zone, $client);
                    $customAddress->sameday_price = !$sameday_price || empty($sameday_price) || $sameday_price == 'default' ? $address->sameday_price : $sameday_price;
                    $customAddress->scheduled_price = !$scheduled_price || empty($scheduled_price) || $scheduled_price == 'default' ? $address->scheduled_price : $scheduled_price;
                    $customAddress->save();
                }
            } elseif ($state == "customize") {
                /** @var CustomAddress $address */
                $address = CustomAddress::find($id);
                $address->sameday_price = !$sameday_price || empty($sameday_price) || $sameday_price == 'default' ? $address->sameday_price : $sameday_price;
                $address->scheduled_price = !$scheduled_price || empty($scheduled_price) || $scheduled_price == 'default' ? $address->scheduled_price : $scheduled_price;
                $address->save();
            }
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @param CustomAddress $address
     * @param bool $back
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, CustomAddress $address, $back = true)
    {
        try {
            $address->delete();
        } catch (\Exception $ex) {
        }
        if ($back)
            return back();
    }

    public function bulkDestroy(Request $request, Client $client)
    {
        $zone = $request->get('customZone');
        $addresses = $this->parseAddresses($request->get('addresses', ''));
        foreach ($addresses as $id => $state) {
            $this->destroy($client, CustomAddress::find($id), false);
        }
        return redirect()->route('clients.zones.show', ['client' => $client, 'zone' => $zone]);
    }

    public function parseAddresses(string $addresses)
    {
        $addresses = explode(',', $addresses);
        $out = [];
        foreach ($addresses as $address_raw) {
            $address_details = explode(':', $address_raw);
            $out[$address_details[0]] = $address_details[1];
        }
        return $out;
    }
}
