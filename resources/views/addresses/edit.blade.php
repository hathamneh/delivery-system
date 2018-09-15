@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('addresses.edit', $zone, $address->id) }}
@endsection

@section('pageTitle')
    <i class='fas fa-map-marker-alt'></i> @lang("zone.address.edit") @lang('common.for') {{ $zone->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                @include('addresses.form')
            </div>
        </div>
    </div>
@endsection