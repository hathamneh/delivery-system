<?php

namespace App\Http\Controllers;

use App\Client;
use App\Courier;
use App\Pickup;
use App\Shipment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics = [
            'pending' => Shipment::pending()->count(),
            'received' => Shipment::received()->count(),
            'delivered' => Shipment::delivered()->count(),
            'pickups' => Pickup::count(),
            'clients' => Client::count(),
            'couriers' => Courier::count(),
        ];
        return view('home')->with(['statistics' => $statistics]);
    }
}
