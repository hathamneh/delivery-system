@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('inventory.index') }}
@endsection

@section('pageTitle')
    <i class='fa-clipboard2'></i> @lang("inventory.today")
@endsection

@section('content')
    <div class="container-fluid">
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
        <div class="table-responsive py-2 px-1 shipments-table">
            <table class="table table-hover dataTable">
                <thead>
                <tr>
                    <th>@lang('client.account_number')</th>
                    <th>@lang('client.trade_name')</th>
                    <th>@lang('client.shipments')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <?php /** @var \App\Client $client */ ?>
                    <tr id="client-{{ $client->account_number }}" data-id="{{ $client->account_number }}">
                        <td>{{ $client->account_number }}</td>
                        <td>{{ $client->trade_name }}</td>
                        <td>{{ $client->shipments()->count() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection