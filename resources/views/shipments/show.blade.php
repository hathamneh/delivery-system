@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments.show', $shipment) }}
@endsection

@section('pageTitle')
    <i class='fa-shipment'></i> @lang("shipment.single"): {{ $shipment->waybill }}
@endsection

@section('content')
    <nav class="nav inner-nav">
        <a href="{{ route('shipments.show', ['shipment'=>$shipment->id, 'tab'=>'status']) }}"
           class="{{ $tab != "status" ?: "active" }}"><i class="fa-info-circle"></i> @lang('shipment.status')</a>
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
    @includeWhen($tab == "summery", "shipments.tabs.summery")
    @includeWhen($tab == "edit", "shipments.tabs.edit")
    @includeWhen($tab == "actions", "shipments.tabs.actions")

@endsection

@section('beforeBody')
    @if($tab == "actions")
        <script>

        </script>
    @endif
@endsection
