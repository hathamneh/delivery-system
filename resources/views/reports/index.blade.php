@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('reports') }}
@endsection

@section('pageTitle')
    <i class='fas fa-reports'></i> @lang("reports.label")
@endsection

@section('actions')
    <div class="container-fluid reports-actions">
        <form class="actions-content" action="{{ route('reports.update') }}" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <input type="hidden" name="shipments" value="">
            <div class="selection-indicator">@lang('reports.with_selected')</div>
            <div class="btn-group">
                <div class="dropdown">
                    <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="changeStatusDropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @lang('shipment.change_status')
                    </button>
                    <div class="dropdown-menu" aria-labelledby="changeStatusDropdown">
                        @foreach($statuses as $status)
                            <button name="status" type="submit" class="dropdown-item"
                                    value="{{ $status->id }}">@lang('shipment.statuses.'.$status->name)</button>
                        @endforeach
                    </div>
                </div>
                <button name="clientPaid" type="submit" class="btn btn-sm btn-success"
                        value="true">@lang('shipment.client_paid')</button>
                <button name="courierCashed" type="submit" class="btn btn-sm btn-light"
                        value="true">@lang('shipment.courier_cashed')</button>
            </div>
        </form>
    </div>
    <div id="reportrange" class="btn btn-outline-secondary">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>
@endsection

@section('content')
    @if(session('alert'))
        <div class="container-fluid">
            @component('bootstrap::alert', [
                'type' => session('alert')->type ?? "primary",
                'dismissible' => true,
                'animate' => true,
               ])
                {!! session('alert')->msg !!}
            @endcomponent
        </div>
    @endif
    <div class="container-fluid reports-filters">
        <div class="form-group row">
            <label class="col-sm-auto">@lang('reports.select_client')</label>
            <div class="col-sm-9">
                @component('clients.search-client-input',[
                    'name' => 'client',
                    'placeholder' => trans('reports.select_client'),
                    'value' => $client->account_number ?? "",
                ]) @endcomponent
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-auto">@lang('reports.select_courier')</label>
            <div class="col-sm-9">
                @component('couriers.search-courier-input',[
                    'name' => 'courier',
                    'placeholder' => trans('reports.select_courier'),
                    'value' => $courier->id ?? "",
                    'text' => $courier->name ?? "",
                ]) @endcomponent
            </div>
        </div>
    </div>
    <div class="container-fluid reports-container">
        <table class="table reports-table table-hover table-selectable dataTable"
               data-ajax="{{ route('api.reports.make') }}">
            <thead>
            <tr>
                <th>
                    <div class="custom-control custom-checkbox" title="@lang('common.selectAll')">
                        <input type="checkbox" class="custom-control-input" id="selectAll">
                        <label class="custom-control-label" for="selectAll"></label>
                    </div>
                </th>
                <th data-name="client_account_number">@lang('client.account_number')</th>
                <th data-name="status" data-class-name="status-column">@lang('shipment.status')</th>
                <th data-name="waybill">@lang('shipment.waybill')</th>
                <th data-name="courier">@lang('courier.label')</th>
                <th data-name="delivery_date">@lang('shipment.delivery_date')</th>
                <th data-name="address">@lang('shipment.address')</th>
                <th data-name="phone_number">@lang('shipment.phone_number')</th>
                <th data-name="delivery_cost">@lang('shipment.delivery_cost')</th>
                <th data-name="shipment_value">@lang('shipment.shipment_value')</th>
                <th data-name="actual_paid_by_consignee">@lang('shipment.actual_paid')</th>
                <th data-name="courier_cashed">@lang('shipment.courier_cashed')</th>
                <th data-name="client_paid">@lang('shipment.client_paid')</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection