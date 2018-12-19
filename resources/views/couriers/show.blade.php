@extends('layouts.couriers')

@section('breadcrumbs')
    {{ Breadcrumbs::render('couriers') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> {{ $courier->name }}
@endsection

@section('content')
    @include("couriers.tabs")

    <div class="container mt-4">
        @include('layouts.partials.overviewStats')
    </div>
@endsection