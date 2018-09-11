<?php

namespace App\Http\Controllers;

use App\Client;
use App\Courier;
use App\Invoice;
use App\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class AccountingController extends Controller
{

    public function __construct()
    {
        View::share([
            "pageTitle"        => "Accounting",
            'sidebarCollapsed' => true,
        ]);
    }

    public function index()
    {
        /** @var Client $client */
        return view('accounting.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'                  => [
                'required',
                Rule::in(['client', 'courier']),
            ],
            'client_account_number' => 'required_if:type,client|exists:clients,account_number',
            'courier_id'            => 'required_if:type,courier|exists:couriers,id',
            'period'                => 'required',
        ]);


        $type = $request->get('type');
        $target = null;
        if ($type == "client")
            $target = $request->get('client_account_number');
        elseif ($type == 'courier')
            $target = $request->get('courier_id');


        $invoice = new Invoice([
            'type'     => $type,
            'target'   => $target,
            'discount' => $request->get('discount'),
            'notes'    => $request->get('notes'),
        ]);
        $invoice->period = $request->get('period');
        $invoice->save();

        return redirect()->route('accounting.invoice', [$invoice]);
    }

    public function goTo(Request $request)
    {
        $request->validate([
            'invoice_number' => "required|exists:invoices,id"
        ]);
        return redirect()->route('accounting.invoice', [$request->get('invoice_number')]);
    }

    public function show(Invoice $invoice)
    {
        $shipments = $invoice->shipments;
        if ($invoice->type == "client") {
            return view('accounting.invoice')->with([
                'shipments' => $shipments,
                'client'    => $invoice->target,
                'invoice'   => $invoice
            ]);
        } elseif($invoice->type == "courier") {
            return view('accounting.courier' ,[
                'courier' => $invoice->target,
                'invoice' => $invoice
            ]);
        }
        return abort(404);
    }
}
