@extends('layouts.app')


@section('breadcrumbs')
    {{ Breadcrumbs::render('couriers.show', $courier) }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> [{{ $courier->name }}] Inventory
@endsection

@section('actions')
    @include('reports.partials.actions', ['client_paid' => false, 'daterange' => false])

    <button class="btn btn-light shipments-filter-btn dropdown-toggle" type="button" data-toggle="popover"
            data-placement="bottom" data-html="true"
            data-content='@include('shipments.partials.filter', $filtersData)' data-title="Filter Shipments">
        <i class="fa-filter mr-2"></i> Filter
    </button>

    <div id="reportrange" class="btn btn-outline-secondary">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        @include('shipments.table', ['dataTable' => false])
        <hr>
        <table class="table table-bordered bg-white inventory-summery-table">
            <tbody>
            @foreach($statuses_keyed as $statusName => $status)
            <tr>
                <th>@lang("shipment.statuses.{$statusName}.name")</th>
                <td>{{ $shipments->where('status_id', $status->id)->count() }}</td>
            </tr>
            @endforeach
            <tr>
                <th>@lang("shipment.total")</th>
                <td>{{ $shipments->count() }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog"
         id="changeStatusModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    @include('shipments.actions.changeStatus', ["formAction" => route("reports.update")])
                    <div class="d-flex mt-3 justify-content-end">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">@lang('common.cancel')</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
