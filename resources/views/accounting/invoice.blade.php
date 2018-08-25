@php /** @var App\Invoice $invoice */ @endphp

@extends('layouts.print')


@section('content')

    <div class="container">

        <section class="invoice sheet padding-10mm">
            <table>
                <tr>
                    <td class="invoice-logo" colspan="2">
                        <img src="/images/logo-fullxhdpi.png" alt="Logo">
                    </td>
                </tr>
                <tr>
                    <td class="invoice__company-details" colspan="2">
                        {{ Setting::get('company.name') }}
                        <br>
                        {!! nl2br(e(Setting::get('company.address')))  !!}
                        <br>
                        @lang('settings.company.pobox'): {{ Setting::get('company.pobox') }}
                        <br>
                        @lang('accounting.telephone'): {{ Setting::get('company.telephone') }}
                        <br>
                        @lang('settings.company.trc') : {{ Setting::get('company.trc') }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="2"><b>@lang('accounting.statement')</b></td>
                </tr>
                <tr>
                    <td colspan="2" class="invoice__statement-table">
                        <div class="row">
                            <div class="col-6">
                                <table>
                                    <tbody>
                                    <tr>
                                        <th>@lang('accounting.to')</th>
                                        <td>{{ $client->trade_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('accounting.address')</th>
                                        <td>{!! nl2br(e($client->address->full)) !!}</td>
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
                                                <td>{{ $client->bank->full }}</td>
                                            </tr>
                                            <tr>
                                                <th>@lang('accounting.account_number')</th>
                                                <td>{{ $client->account_number }}</td>
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
                    <td colspan="2">
                        <table class="table invoice-table table-bordered">
                            <thead>
                            <tr role="row" class="head-tr">
                                <th class="">#</th>
                                <th>@lang('accounting.hawb')</th>
                                <th>@lang('accounting.status')</th>
                                <th>@lang('accounting.delivery_date')</th>
                                <th>@lang('accounting.address')</th>
                                <th>@lang('accounting.service_type')</th>
                                <th>@lang('accounting.weight')</th>
                                <th>@lang('accounting.pieces')</th>
                                <th>@lang('accounting.shipment_value')</th>
                                <th>@lang('accounting.collected_value')</th>
                                <th>@lang('accounting.base_charge')</th>
                                <th>@lang('accounting.extra_fees')</th>
                                <th>@lang('accounting.extra_services')</th>
                                <th>@lang('accounting.net')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i = 0; @endphp
                            @foreach($shipments as $shipment)
                                @php /** @var \App\Shipment $shipment */ @endphp
                                <tr>
                                    <td rowspan="2" class="separator-bottom">{{ ++$i }}</td>
                                    <td>{{ $shipment->waybill }}</td>
                                    <td>@lang("shipment.statuses.".$shipment->status->name)</td>
                                    <td>{{ $shipment->delivery_date->toFormattedDateString() }}</td>
                                    <td>{{ $shipment->address->name }}</td>
                                    <td>@lang("accounting.service_types.".$shipment->service_type)</td>
                                    <td>{{ $shipment->package_weight }}</td>
                                    <td>{{ $shipment->pieces }}</td>
                                    <td>{{ fnumber($shipment->shipment_value) }}</td>
                                    <td>{{ fnumber($shipment->actual_paid_by_consignee) }}</td>
                                    @if($shipment->isPriceOverridden())
                                        <td colspan="3">{{ fnumber($shipment->base_charge) }}</td>
                                    @else
                                        <td>{{ fnumber($shipment->base_charge) }}</td>
                                        <td>{{ fnumber($shipment->extra_fees) }}</td>
                                        <td>{{ fnumber($shipment->services_cost) }}</td>
                                    @endif
                                    <td class="font-weight-bold text-center separator-bottom"
                                        rowspan="2">{{ fnumber($shipment->delivery_cost) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="12" class="light-bg separator-bottom">
                                        <div>
                                            @lang('accounting.operational_details'):
                                            <ul class="operational-details">
                                                <li><b>@lang('accounting.consignee_info')
                                                        :</b> {{ $shipment->consignee_name }}
                                                    , {{ $shipment->phone_number }}</li>
                                                @if($shipment->services->count())
                                                    <li><b>@lang('accounting.extra_services'):</b>
                                                        @foreach($shipment->services as $service)
                                                            @php /** @var \App\Service $service */ @endphp
                                                            <span class="invoice__service-item">({{ $service->name }}
                                                                , {{ fnumber($service->price) }})</span>
                                                        @endforeach
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
                                <th>@lang('accounting.terms_applied')</th>
                                <td>{{ $invoice->terms_applied }}</td>
                            </tr>
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
            </table>
        </section>

    </div>
@endsection