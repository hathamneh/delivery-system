@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments') }}
@endsection

@section('pageTitle')
    <i class='fa-shipment'></i> {{ $pageTitle }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include("shipments.table")
            </div>
        </div>
    </div>
@endsection