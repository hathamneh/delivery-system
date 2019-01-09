@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments') }}
@endsection

@section('pageTitle')
    <i class='fa-shipment'></i> {{ $pageTitle }}
@endsection

@section('actions')

    <button class="btn btn-light shipments-filter-btn dropdown-toggle" type="button" data-toggle="popover" data-placement="bottom" data-html="true"
            data-content='@include('shipments.partials.filter', $filtersData)' data-title="Filter Shipments">
        <i class="fa-filter mr-2"></i> Filter
    </button>

    <div id="reportrange" class="btn btn-outline-secondary">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>

    @can('create', \App\Shipment::class)
        <a href="{{ route('shipments.create') }}" class="btn btn-info"><i
                    class="fa-plus-circle"></i> <span>@lang('shipment.new')</span>
        </a>
    @endif
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include("shipments.table")
            </div>
        </div>
    </div>
@endsection