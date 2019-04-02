@php /** @var \App\Shipment|\App\ReturnedShipment $shipment */ @endphp

@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments.show', $shipment) }}
@endsection

@section('pageTitle')
    <i class='fa-shipment'></i> @lang("shipment.single"): {{ $shipment->waybill }}
    @if($shipment instanceof \App\ReturnedShipment)
        <small class="text-muted"> - to return <a href="{{ route('shipments.show', [$shipment->returnedFrom]) }}">{{ $shipment->returnedFrom->waybill }}</a></small>
    @elseif(!is_null($shipment->returnedIn))
        <small class="text-muted"> - to be returned in <a href="{{ route('shipments.show', [$shipment->returnedIn]) }}">{{ $shipment->returnedIn->waybill }}</a></small>
    @endif
@endsection

@section('actions')
    <a href="{{ route('shipments.print', [$shipment]) }}" class="btn btn-outline-secondary"><i class="fa-print"></i> Print</a>
@endsection

@section('content')
    <nav class="nav inner-nav">
        <a href="{{ route('shipments.show', ['shipment'=>$shipment->id, 'tab'=>'status']) }}"
           class="{{ $tab != "status" ?: "active" }}"><i class="fa-info-circle"></i> @lang('shipment.status_tab')</a>
        @if(auth()->user()->isAuthorized('shipments'))
            <a href="{{ route('shipments.show', ['shipment'=>$shipment->id, 'tab'=>'changelog']) }}"
               class="{{ $tab != "changelog" ?: "active" }}"><i class="fa-info-circle"></i> @lang('shipment.changelog')</a>
        @endif
        @if(auth()->user()->isAuthorized('shipments'))
            <a href="{{ route('shipments.show', ['shipment'=>$shipment->id, 'tab'=>'summery']) }}"
               class="{{ $tab != "summery" ?: "active" }}"><i class="fa-info-circle"></i> @lang('shipment.summery')</a>
        @endif
        @if(auth()->user()->isAuthorized('shipments', \App\Role::UT_UPDATE))
            <a href="{{ route('shipments.show', ['shipment'=>$shipment->id, 'tab'=>'actions']) }}"
               class="{{ $tab != "actions" ?: "active" }}"><i class="fa-cogs"></i> @lang('shipment.actions')</a>
        @endif
        @if(auth()->user()->isAuthorized('shipments', \App\Role::UT_DELETE))
            <a href="{{ route('shipments.edit', ['shipment'=>$shipment->id]) }}"
               class="{{ $tab != "edit" ?: "active" }}"><i class="fa-pencil-alt"></i> @lang('shipment.edit')</a>
        @endif
    </nav>

    @includeWhen($tab == "status", "shipments.tabs.status")
    @includeWhen($tab == "changelog", "shipments.tabs.log")
    @includeWhen($tab == "summery", "shipments.tabs.summery")
    @includeWhen($tab == "edit", "shipments.tabs.edit")
    @includeWhen($tab == "actions", "shipments.tabs.actions")

@endsection
