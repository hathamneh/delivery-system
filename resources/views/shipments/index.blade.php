@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments') }}
@endsection

@section('pageTitle')
    <i class='fa-shipment'></i> {{ $pageTitle }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include("shipments.table")
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection