<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourierDashboard extends Controller
{
    public function index()
    {
        return view('couriers.dashboard');
    }
}
