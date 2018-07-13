<?php

namespace App\Http\Controllers;

use App\Client;
use App\Courier;
use App\Pickup;
use Illuminate\Http\Request;

class PickupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pickups = (object)[
            'all' => Pickup::all(),
            'pending' => Pickup::pending()->get(),
            'completed' => Pickup::completed()->get(),
            'declined' => Pickup::declined()->get(),
        ];
        return view('pickups.index', compact('pickups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $couriers = Courier::all();
        return view('pickups.create')->with([
            'couriers' => $couriers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pickup = new Pickup;
        $pickup->client()->associate(Client::findOrFail($request->get('client_account_number')));
        $pickup->available_time = $request->get('available_time');
        $pickup->courier()->associate(Courier::findOrFail($request->get('courier_id')));
        $pickup->expected_packages_number = $request->get('expected_packages_number');
        $pickup->pickup_fees = $request->get('pickup_fees', 0);
        $pickup->phone_number = $request->get('phone_number', 0);

        $pickup->pickup_from = $request->get('pickup_from');
        $pickup->pickup_address_text = $request->get('pickup_address_text');
        $pickup->pickup_address_maps = $request->get('pickup_address_maps');
        $pickup->notes_internal = $request->get('pickup_address_maps');

        // todo : Attach shipments

        $pickup->save();

        return redirect()->route('pickups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function show(Pickup $pickup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function edit(Pickup $pickup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pickup $pickup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pickup $pickup)
    {
        //
    }
}
