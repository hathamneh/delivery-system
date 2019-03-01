<?php

namespace App\Http\Controllers;

use App\Client;
use App\Courier;
use App\Guest;
use App\Http\Middleware\IsAdmin;
use App\Invoice;
use App\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class AccountingController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');

        View::share([
            "pageTitle"        => "Accounting",
            'sidebarCollapsed' => true,
        ]);
    }

    public function index()
    {

        /** @var Client $client */
        return view('accounting.index')->with([
            'invoices' => Invoice::forClientsAndGuests()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'                  => [
                'required',
                Rule::in(['client', 'courier', 'national_id']),
            ],
            'client_account_number' => 'required_if:type,client|exists:clients,account_number',
            'courier_id'            => 'required_if:type,courier|exists:couriers,id',
            'national_id'           => 'required_if:type,national_id',
            'period'                => 'required',
        ]);


        $type   = $request->get('type');
        $target = null;
        if ($type == "client")
            $target = $request->get('client_account_number');
        elseif ($type == 'courier')
            $target = $request->get('courier_id');
        elseif ($type == 'national_id') {
            $nationalId   = $request->get('national_id');
            $targetObject = $this->getTargetByNationalId($nationalId);
            if (!is_null($targetObject)) {
                $target = $targetObject->getKey();
                if ($targetObject instanceof Client)
                    $type = "client";
                elseif ($targetObject instanceof Guest)
                    $type = "guest";
            } else {
                return back()->withErrors(['national_id' => "No client/guest found with provided national ID."]);
            }
        }


        $invoice         = new Invoice([
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
        } elseif ($invoice->type == "guest") {
            return view('accounting.guestInvoice')->with([
                'shipments' => $shipments,
                'client'    => $invoice->target,
                'invoice'   => $invoice
            ]);
        } elseif ($invoice->type == "courier") {
            return view('accounting.courier', [
                'shipments' => $shipments,
                'courier'   => $invoice->target,
                'invoice'   => $invoice
            ]);
        }
        return abort(404);
    }

    public function markAsPaid(Request $request, Invoice $invoice)
    {
        $request->validate([
            'type' => 'required'
        ]);
        $type = $request->get('type');
        switch ($type) {
            case "client":
                $invoice->markAsClientPaid();
                break;
            case "courier":
                $invoice->markAsCourierCashed();
                break;
        }
        return back();
    }

    public function getTargetByNationalId($nationalId)
    {
        if (Client::where('national_id', $nationalId)->exists())
            return Client::where('national_id', $nationalId)->first();
        if (Guest::where('national_id', $nationalId)->exists())
            return Guest::where('national_id', $nationalId)->first();
        return null;
    }
}
