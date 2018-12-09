@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('services.create') }}
@endsection

@section('pageTitle')
    <i class='fa-handshake2'></i> @lang("service.create")
@endsection

@section('actions')
    <a href="{{ route('services.index') }}" class="btn btn-primary"><i
                class="fa-handshake2"></i> <span>@lang('service.label')</span>
    </a>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route("services.store") }}" method="post">
            {{ csrf_field() }}
            @include('services.form')
        </form>
    </div>
@endsection
