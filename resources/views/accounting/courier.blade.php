@php
    /** @var App\Invoice $invoice */
    /** @var App\Courier $courier */
@endphp

@extends('layouts.invoice')


@section('invoiceContent')
    <tr>
        <td class="text-center" colspan="2"><b style="font-size: 1.1rem;">@lang('accounting.statement')</b></td>
    </tr>
    <tr>
        <td colspan="2" class="invoice__statement-table">
            <div class="row">
                <div class="col-6">
                    <table>
                        <tbody>
                        <tr>
                            <th>@lang('accounting.courier_name')</th>
                            <td>{{ $courier->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('accounting.address')</th>
                            <td>{{ $courier->address }}</td>
                        </tr>
                        <tr>
                            <th>@lang('accounting.telephone')</th>
                            <td>{{ $courier->phone_number }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <table>
                                <tbody>
                                <tr>
                                    <th>@lang('accounting.invoice_no')</th>
                                    <td>{{ $invoice->id }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('accounting.invoice_date')</th>
                                    <td>{{ $invoice->created_at->toFormattedDateString() }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('accounting.invoice_period')</th>
                                    <td>{{ $invoice->period }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </td>
    </tr>
    <tr>
        <td colspan="2" class="invoice__statement-table">
            @include('accounting.shipments')
        </td>
    </tr>
    <tr>
        <td colspan="2" class="invoice__summery">
            <h3>@lang('accounting.summery')</h3>
            <table class="invoice__summery-table">
                <tbody>
                <tr>
                    <th>Due For - Delivery Cost Share</th>
                    <td><span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->due_for['share']) }}
                    </td>
                </tr>
                <tr>
                    <th>Due For - Promotion</th>
                    <td><span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->due_for['promotion']) }}
                    </td>
                </tr>
                <tr>
                    <th>@lang('accounting.client_due_from')</th>
                    <td><span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->due_from) }}
                    </td>
                </tr>
                <tr>
                    <th {{{ $invoice->terms_applied ? "rowspan='2'" : "" }}}>@lang('accounting.terms_applied')</th>
                    <td>{{ $invoice->the_discount }}</td>
                </tr>
                @if($invoice->terms_applied)
                    <tr>
                        <td>
                            <span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->terms_applied) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>@lang('accounting.pickups_fees')</th>
                    <td>
                        <span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->pickup_fees) }}
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>@lang('accounting.total_net')</th>
                    <td><span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->total) }}</td>
                </tr>
                </tfoot>
            </table>
        </td>
    </tr>

@endsection