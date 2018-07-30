@extends('layouts.clients')


@section('breadcrumbs')
    {{ Breadcrumbs::render('clients') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("client.label")
@endsection

@section('content')
    <nav class="nav inner-nav">
        <a href="{{ route('clients.show', ['client'=>$client, 'tab'=>'statistics']) }}"
           class="{{ $tab != "statistics" ?: "active" }}"><i class="fa-chart-line"></i> @lang('client.statistics')</a>

        <a href="{{ route('clients.show', ['client'=>$client, 'tab'=>'shipments']) }}"
           class="{{ $tab != "shipments" ?: "active" }}"><i class="fa-info-circle"></i> @lang('client.shipments')</a>

        <a href="{{ route('clients.show', ['client'=>$client, 'tab'=>'pickups']) }}"
           class="{{ $tab != "pickups" ?: "active" }}"><i class="fa-cogs"></i> @lang('client.pickups')</a>

        <a href="{{ route('clients.edit', ['client'=>$client]) }}"
           class="{{ $tab != "edit" ?: "active" }}"><i class="fa-pencil-alt"></i> @lang('client.edit')</a>
    </nav>

    <div class="container mt-4">
        @includeWhen($tab == "statistics", "clients.statistics")
        @includeWhen($tab == "shipments", "shipments.table")
        @includeWhen($tab == "edit", "clients.edit")
        @includeWhen($tab == "pickups", "pickups.pickups-list")
    </div>
@endsection

@section('beforeBody')
    @if($tab=="pickups")
        <script src="{{ asset('js/plugins/mixitup.min.js') }}"></script>
        <script src="{{ asset('js/legacy/pickups.js') }}"></script>
    @endif
@endsection