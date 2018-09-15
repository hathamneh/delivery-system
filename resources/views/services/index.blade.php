@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('services') }}
@endsection

@section('pageTitle')
    <i class='fa-handshake2'></i> @lang("service.label")
@endsection

@section('actions')
    <a href="{{ route('services.create') }}" class="btn btn-primary"><i
                class="fa-plus-circle"></i> <span>@lang('service.create')</span>
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @if(session('alert'))
                <div class="col-12">
                    @component('bootstrap::alert', [
                        'type' => session('alert')->type ?? "primary",
                        'dismissible' => true,
                        'animate' => true,
                       ])
                        {{ session('alert')->msg }}
                    @endcomponent
                </div>
            @endif
            @include('services.list')
        </div>
    </div>
@endsection
