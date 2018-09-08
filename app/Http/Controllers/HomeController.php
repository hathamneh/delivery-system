<?php

namespace App\Http\Controllers;

use App\Client;
use App\Courier;
use App\Pickup;
use App\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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

        View::share([
            'pageTitle' => trans('sidebar.dashboard')
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        if (Auth::user()->isAdmin())
            $data['statistics'] = [
                'pending'   => Shipment::pending()->count(),
                'received'  => Shipment::statusIs('received')->count(),
                'delivered' => Shipment::statusIs('delivered')->count(),
                'returned'  => Shipment::statusIs('returned')->count(),
                'pickups'   => Pickup::count(),
                'clients'   => Client::count(),
                'couriers'  => Courier::count(),
            ];

        return view('home')->with($data);
    }
}
