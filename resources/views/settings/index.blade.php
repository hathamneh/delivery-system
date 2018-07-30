@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('settings') }}
@endsection

@section('pageTitle')
    <i class='fas fa-map-marker-alt'></i> @lang("settings.label")
@endsection

@section('content')
    <div class="container">
    <h2>Welcome to Settings :)</h2>
    <div class="alert alert-warning">
        UNDER CONSTRUCTION
    </div>
    </div>
@endsection