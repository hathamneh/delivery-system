<?php

namespace App\Http\Controllers;

use App\Client;
use App\Courier;
use App\Inventory;
use App\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::createForToday();
        return view('inventory.index', [
            'clients' => $inventory->clients()
        ]);
    }

    public function courier(Request $request)
    {
        $request->validate([
            'courier' => 'nullable|exists:couriers,id'
        ]);
        $data = [];
        if ($request->has('courier')) {
            $courier = Courier::find($request->get('courier'));
            $inventory = Inventory::createForToday($courier);
            $data['inventory'] = $inventory;
            $data['courier'] = $courier;
        }
        return view('inventory.couriers')->with($data);
    }
}
