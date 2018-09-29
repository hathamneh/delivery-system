@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments') }}
@endsection

@section('pageTitle')
    <i class='fa-shipment'></i> {{ $pageTitle }}
@endsection

@section('actions')
    @if(auth()->user()->isAuthorized('shipments', \App\Role::UT_CREATE))
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