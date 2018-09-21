<?php

namespace App\Http\Controllers;

use App\Client;
use App\Shipment;
use Illuminate\Http\Request;

class MailingController extends Controller
{
    public function index()
    {
        return view('mailing.index', [
            'client' => $this->demoClient(),
            'shipment' => $this->demoShipment()
        ]);
    }

    public function demoClient()
    {
        return (new Client)->fill([
            'name'           => "Client Name",
            'trade_name'     => "Trade Name",
            'account_number' => 99999,
            'password'       => "##########"
        ]);
    }

    public function demoShipment()
    {
        return (new Shipment)->fill([
            'waybill' => 999999999,
            'status_notes' => "DEMO REASON"
        ]);
    }
}
