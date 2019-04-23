<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Client;
use App\Invoice;
use App\Mail\BroadcastEmail;
use App\Shipment;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailingController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('mailing.index', [
            'client'   => $this->demoClient(),
            'shipment' => $this->demoShipment(),
            'invoice'  => $this->demoInvoice()
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
            'waybill'      => 999999999,
            'status_notes' => "DEMO REASON",
            'branch_id'    => 1
        ]);
    }

    public function demoInvoice()
    {
        return (new Invoice)->fill([
            'from'  => now()->subDays(30),
            'until' => now(),
        ]);
    }

    public function broadcast(Request $request)
    {
        $request->validate([
            'broadcast_for'     => ['required', Rule::in(['clients', 'couriers'])],
            'broadcast_subject' => 'required',
            'broadcast_body'    => 'required'
        ]);
        if($request->get('broadcast_for') === "clients")
            $recipients = User::clients()->whereNotNull('email')->get();
        elseif($request->get('broadcast_for') === "couriers")
            $recipients = User::couriers()->whereNotNull('email')->get();
        else
            return back();

        Mail::to($recipients)->send(new BroadcastEmail($request->get('broadcast_subject'), $request->get('broadcast_body')));

        return back();
    }

}
