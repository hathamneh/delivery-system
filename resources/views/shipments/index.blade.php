@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments') }}
@endsection

@section('pageTitle')
    <i class='fa-shipment'></i> {{ $pageTitle }}
@endsection

@section('actions')

    <form action="{{ route('shipments.assignCourier') }}" method="POST" id="assignCourierForm">
        @method('PUT')
        @csrf
        @component('bootstrap::modal',[
                'id' => 'assignCourierModal'
            ])
            @slot('title')
                @lang("shipment.assignCourierTitle")
            @endslot
            <div class="form-group">
                <label for="courier">@lang('courier.single')</label>
                @component('couriers.search-courier-input',[
                    'name' => 'courier',
                    'placeholder' => trans('courier.single'),
                    'value' => "",
                    'text' => "",
                ]) @endcomponent
            </div>

            @slot('footer')
                <div class="d-flex flex-row-reverse w-100">
                    <button class="btn btn-primary" type="submit">@lang('shipment.assignCourier') <i
                                class="fa fa-arrow-right"></i>
                    </button>
                    <button class="btn btn-outline-secondary mr-auto"
                            data-dismiss="modal">@lang('common.cancel')</button>
                </div>
            @endslot
        @endcomponent
    </form>
    <button type="button" class="btn btn-secondary" data-toggle="modal"
            data-target="#assignCourierModal" disabled>@lang('shipment.assignCourier')</button>

    <button class="btn btn-light shipments-filter-btn dropdown-toggle" type="button" data-toggle="popover"
            data-placement="bottom" data-html="true"
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
    @php
        session()->forget('changed');
    @endphp
@endsection