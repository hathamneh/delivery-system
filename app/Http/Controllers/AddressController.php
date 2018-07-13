<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Resources\AddressCollection;
use App\Zone;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param Zone $zone
     * @param  \Illuminate\Http\Request $request
     * @return AddressCollection
     */
    public function store(Zone $zone, Request $request)
    {
        $address = $zone->addresses()->create($request->toArray());
        return new AddressCollection($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Zone $zone
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone, $address)
    {
        $address = $zone->addresses()->findOrFail($address);;
        return view('addresses.edit', [
            'zone'    => $zone,
            'address' => $address
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Zone $zone
     * @param $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone, $address)
    {
        $address = $zone->addresses()->findOrFail($address);
        $address->update($request->toArray());
        return redirect()->route('zones.edit', ['zone' => $zone->id])->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans('zone.address.updated')
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Zone $zone
     * @param Address $address
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function destroy(Zone $zone, Address $address, Request $request)
    {
        $res = $address->delete();
        if ($request->isXmlHttpRequest()) {
            return ['deleted' => $res];
        }
        return redirect()->route('zones.edit', ['zone' => $zone->id]);
    }
}
