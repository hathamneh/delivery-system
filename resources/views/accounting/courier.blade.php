@php /** @var App\Invoice $invoice */ @endphp

@extends('layouts.invoice')


@section('invoiceContent')
    <tr>
        <td colspan="2" class="invoice__statement-table">
            <p>
                <b>Courier name:</b> <span>{{ $courier->name }}</span>
                <br>
                <b>Date range:</b> <span>{{ $invoice->period }}</span>
            </p>

            <div class="d-flex">
                <div class="flex-fill">
                    <b>Due From:</b>
                    <p>Actual Paid by Consignee {!! $invoice->due_from !!}</p>
                </div>
                <div class="flex-fill">
                    <b>Due for:</b>
                    <p>
                        Delivery Cost Share: {!! $invoice->due_for['share'] !!}
                        <br>
                        Promotion: {!! $invoice->due_for['promotion'] !!} </p>
                </div>
            </div>

        </td>
    </tr>
@endsection