<?php


namespace App\Exports;


use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{

    /** @var Invoice  */
    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function view(): View
    {
        return view('accounting.invoice-export', [
            'shipments' => $this->invoice->shipments,
            'client'    => $this->invoice->target,
            'invoice'   => $this->invoice
        ]);
    }
}