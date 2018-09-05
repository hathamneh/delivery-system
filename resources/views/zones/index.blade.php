@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('zones') }}
@endsection

@section('pageTitle')
    <i class='fas fa-map-marker-alt'></i> @lang("zone.label")
@endsection

@section('actions')
    <div class="ml-auto d-flex px-2 align-items-center">
        <div class="btn-group" role="group">
            <a href="{{ route('zones.create') }}" class="btn btn-secondary"><i
                        class="fa fa-plus-circle mr-2"></i> @lang('zone.new')</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        @include('zones.list')
    </div>
@endsection