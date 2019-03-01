@extends('layouts.couriers')


@section('breadcrumbs')
    {{ Breadcrumbs::render('couriers') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("courier.label")
@endsection

@section('content')
    <div class="container">
        @if(session('alert'))
            <div class="">
                @component('bootstrap::alert', [
                    'type' => session('alert')->type ?? "primary",
                    'dismissible' => true,
                    'animate' => true,
                   ])
                    {{ session('alert')->msg }}
                @endcomponent
            </div>
        @endif

        @if(auth()->user()->isAdmin())
            @if(isset($haveWorkTodayCouriers) && $haveWorkTodayCouriers->count())
                <div class="card border-warning bg-light">
                    <div class="card-header text-black border-warning">
                        <span class="font-weight-bold">Couriers Have Work Today</span>
                    </div>
                    <div class="card-body">
                        @include("couriers.open-account-table")

                    </div>
                </div>

                <h3 class="font-weight-bold">@lang('courier.all')</h3>
            @endif
        @endif
        @include("couriers.table")

    </div>
@endsection