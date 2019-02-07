@php
    /** @var App\Invoice $invoice */
    /** @var App\Client $client */
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
                            <th>@lang('accounting.to')</th>
                            <td>{{ $client->trade_name }} / {{ $client->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('accounting.address')</th>
                            <td>{{ $client->pickup_address->text }}</td>
                        </tr>
                        <tr>
                            <th>@lang('accounting.telephone')</th>
                            <td>{{ $client->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>@lang('accounting.attn')</th>
                            <td>{{ $client->name }}</td>
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
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 mt-2">
                            <table>
                                <tbody>
                                <tr>
                                    <th>@lang('accounting.bank_info')</th>
                                    <td>{!! $client->bank->full !!}</td>
                                </tr>
                                <tr>
                                    <th>@lang('accounting.account_number')</th>
                                    <td>{{ $client->account_number }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('accounting.invoice_period')</th>
                                    <td>{{ $invoice->period }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('client.payment_method')</th>
                                    <td>@lang('client.payment_methods.'.$client->paymentMethod->name)</td>
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
        <td colspan="2">
            @include('accounting.shipments')
        </td>
    </tr>
    <tr>
        <td colspan="2" class="invoice__summery">
            <h3>@lang('accounting.summery')</h3>
            <table class="invoice__summery-table">
                <tbody>
                <tr>
                    <th>@lang('accounting.client_due_for')</th>
                    <td><span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->due_for) }}
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
                <tr>
                    <th>@lang('client.payment_method_price')</th>
                    <td>
                        <span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->payment_method_price ?? 0) }}
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