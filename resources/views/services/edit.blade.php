@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('services.edit', $service) }}
@endsection

@section('pageTitle')
    <i class='fa-handshake2'></i> @lang("service.edit")
@endsection

@section('actions')
    <a href="{{ route('services.index') }}" class="btn btn-primary"><i
                class="fa-handshake2"></i> <span>@lang('service.label')</span>
    </a>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route("services.update", [$service]) }}" method="post">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            @include('services.form')
        </form>
    </div>
@endsection
