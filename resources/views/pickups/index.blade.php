@extends('layouts.pickups')


@section('breadcrumbs')
    {{ Breadcrumbs::render('pickups') }}
@endsection

@section('pageTitle')
    <i class='fa-shopping-bag'></i> @lang("pickup.label")
@endsection

@section('actionsFirst')
    <div id="reportrange" class="btn btn-outline-secondary">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>
@endsection

@section('content')
    <div class="container">
        @component('pickups.pickups-list', ['pickups' => $pickups]) @endcomponent
    </div>
@endsection

@section('beforeBody')
    <script src="{{ asset('js/plugins/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/legacy/pickups.js') }}"></script>
@endsection