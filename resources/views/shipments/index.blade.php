@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments') }}
@endsection

@section('pageTitle')
    <i class='fa-shipment'></i> @lang("shipment.label")
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shipments-table">
                    <table class="table table-hover dataTable">
                        <thead>
                        <tr>
                            <th>@lang('client.trade_name')</th>
                            <th>@lang('shipment.client_account_number')</th>
                            <th>@lang('shipment.consignee_name')</th>
                            <th>@lang('shipment.waybill')</th>
                            <th>@lang('shipment.delivery_date')</th>
                            <th>@lang('shipment.courier.label')</th>
                            <th>@lang('shipment.address')</th>
                            <th>@lang('shipment.service_type.label')</th>
                            <th>@lang('shipment.status')</th>
                            <th>@lang('shipment.shipment_value')</th>
                            <th>@lang('shipment.delivery_cost')</th>
                            <th>@lang('shipment.actual_paid')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shipments as $shipment)
                            @php /** @var \App\Shipment $shipment */ @endphp
                            <tr data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}" title="Open shipment details">
                                <td>{{ $shipment->client->trade_name }}</td>
                                <td>{{ $shipment->client_account_number }}</td>
                                <td>{{ $shipment->consignee_name }}</td>
                                <td>{{ $shipment->waybill }}</td>
                                <td>{{ $shipment->delivery_date }}</td>
                                <td>{{ $shipment->courier->name }}</td>
                                <td>{{ $shipment->address->name }}</td>
                                <td>{{ trans($shipment->service_type) }}</td>
                                <td><span title="{{ $shipment->status->description }}"
                                          data-toggle="tooltip">{{ trans($shipment->status->name) }}</span></td>
                                <td>{{ $shipment->shipment_value }}</td>
                                <td>{{ $shipment->delivery_cost }}</td>
                                <td>{{ $shipment->actual_paid_by_consignee }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection