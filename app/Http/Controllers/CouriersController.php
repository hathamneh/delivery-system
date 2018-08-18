<?php

namespace App\Http\Controllers;

use App\Courier;
use App\Http\Requests\StoreCourierRequest;
use App\User;
use App\Zone;
use Illuminate\Http\Request;

class CouriersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couriers = Courier::all();
        return view('couriers.index')->with([
            'couriers' => $couriers,
            'pageTitle' => trans('courier.label')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones = Zone::all();
        return view('couriers.create')->with([
            'zones' => $zones,
            'pageTitle' => trans('courier.create')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourierRequest $request)
    {
        $courier = new Courier;
        $courier->name = $request->get('name');
        $courier->password = User::generatePassword();
        $courier->phone_number = $request->get('phone_number');
        $courier->address = $request->get('address');
        $courier->category = $request->get('category');
        $courier->notes = $request->get('notes');
        $courier->zone()->associate($request->get('zone_id'));

        $courier->save();

        $courier->createUser();
        $courier->uploadAttachments($request->file('courier_files'));

        return redirect()->route('couriers.index')->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans('courier.created')
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Courier $courier
     * @return \Illuminate\Http\Response
     */
    public function show(Courier $courier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Courier $courier
     * @return \Illuminate\Http\Response
     */
    public function edit(Courier $courier)
    {
        $zones = Zone::all();
        return view('couriers.edit', [
            'courier' => $courier,
            'zones'   => $zones,
            'pageTitle' => trans('courier.edit')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Courier $courier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Courier $courier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Courier $courier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Courier $courier)
    {
        $alert = $alert = (object)[
            'type' => 'success',
            'msg'  => trans('courier.deleted')
        ];
        try {
            $courier->delete();
        } catch (\Exception $e) {
            $alert = (object)[
                'type' => 'danger',
                'msg'  => trans('courier.failed')
            ];
        }
        return redirect()->route('couriers.index')->with([
            'alert' => $alert,
        ]);
    }
}
