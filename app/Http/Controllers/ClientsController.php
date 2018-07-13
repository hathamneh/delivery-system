<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreClientRequest;
use App\User;
use App\Zone;
use Illuminate\Http\Request;

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
            'clients' => $clients
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
            'next_account_number' => Client::nextAccountNumber()
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
        $client->trade_name = $request->trade_name;
        $client->password = User::generatePassword();
        $client->name = $request->name;
        $client->phone_number = $request->get('phone_number', null);
        $client->email = $request->get('email', null);
        $client->address = $request->get('address', []);
        $client->zone()->associate(Zone::findOrFail($request->get('zone_id', 0)));
        $client->pickup_address = $request->get('pickup_address', []);
        $client->sector = $request->get('sector', null);
        $client->category = $request->get('category', null);
        $client->bank = $request->get('bank', []);
        $client->bank = $request->get('bank', []);
        $client->urls = $request->get('urls', []);

        $client->save();
        $client->createUser();
        $client->uploadAttachments($request->file('client_files'));

        return redirect()->route('clients.index');
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
     * @param Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $countries = \Countries::lookup();
        $zones = Zone::all();
        return view('clients.edit', compact('client', 'countries', 'zones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        return redirect()->route('clients.index');
    }
}
