<?php

namespace App\Http\Controllers;

use App\Client;
use App\Courier;
use App\Pickup;
use App\Shipment;
use App\User;
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
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin())
            $data =  $this->adminStats();
        elseif ($user->isCourier())
            $data = $this->courierData();
        $data['hasUnreadNotes'] = $user->hasUnreadNotes();
        return view('home')->with($data);
    }

    public function adminStats()
    {
        return [
            'title' => "Admin Dashboard",
            'statistics' => [
                'normal'   => [
                    'today' =>  Shipment::today()->type(["normal"])->count(),
                    'lifetime' =>  Shipment::type(["normal"])->count(),
                ],
                'returned'   => [
                    'today' =>  Shipment::today()->type(["returned"])->count(),
                    'lifetime' =>  Shipment::type(["returned"])->count(),
                ],
                'pickups'   => [
                    'today' => Pickup::today()->count(),
                    'lifetime' => Pickup::count(),
                ],
                'clients'   => [
                    'today' => Client::createdToday()->count(),
                    'lifetime' => Client::count()
                ],
                'couriers'  => [
                    'today' => Courier::createdToday()->count(),
                    'lifetime' => Courier::count()
                ],
            ]
        ];
    }

    public function courierData()
    {
        /** @var Courier $courier */
        $courier = Auth::user()->courier;
        return [
            'title' => "Courier Dashboard",
            'statistics' => [
                'normal'   => [
                    'today' =>  $courier->shipments()->today()->type(["normal"])->count(),
                    'lifetime' =>  $courier->shipments()->type(["normal"])->count(),
                ],
                'returned'   => [
                    'today' =>  $courier->shipments()->today()->type(["returned"])->count(),
                    'lifetime' =>  $courier->shipments()->type(["returned"])->count(),
                ],
                'pickups'   => [
                    'today' => $courier->pickups()->today()->count(),
                    'lifetime' => $courier->pickups()->count(),
                ],
            ]
        ];
    }
}
