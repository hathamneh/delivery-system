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

        @if(isset($openedAccountCouriers) && $openedAccountCouriers->count())
            <div class="card border-warning bg-light">
                <div class="card-header bg-warning text-black">
                    <span class="font-weight-bold">Couriers With Open Account</span>
                </div>
                <div class="card-body">
                    @include("couriers.open-account-table")

                </div>
            </div>

            <h3 class="font-weight-bold">@lang('courier.all')</h3>
        @endif()
        @include("couriers.table")

    </div>
@endsection