@extends('layouts.clients')


@section('breadcrumbs')
    {{ Breadcrumbs::render('clients') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("client.label")
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @if(session('alert'))
                <div class="col-md-8 mx-auto">
                    @component('bootstrap::alert', [
                        'type' => session('alert')->type ?? "primary",
                        'dismissible' => true,
                        'animate' => true,
                       ])
                        {!! session('alert')->msg  !!}
                    @endcomponent
                </div>
            @endif
            <div class="col-12">

                <div class="table-responsive py-2">
                    <table class="table table-hover dataTable">
                        <thead>
                        <tr>
                            <th>@lang('client.account_number')</th>
                            <th>@lang('client.trade_name')</th>
                            <th>@lang('client.phone')</th>
                            <th>@lang('client.bank.name')</th>
                            <th>@lang('client.password')</th>
                            <th>@lang('common.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <?php /** @var \App\Client $client */ ?>
                            <tr id="client-{{ $client->account_number }}" data-id="{{ $client->account_number }}">
                                <td>{{ $client->account_number }}</td>
                                <td>{{ $client->trade_name }}</td>
                                <td>{{ $client->phone_number }}</td>
                                <td>{{ $client->bank_name }}</td>
                                <td>{{ $client->password }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="btn-group">
                                            <a href="{{ route('clients.show', ['client'=>$client->account_number]) }}"
                                               data-toggle="tooltip"
                                               class="btn btn-light btn-sm" title="@lang('client.dashboard')">
                                                <i class="fa-tachometer-alt"></i></a>
                                            <a href="{{ route('clients.edit', ['client'=>$client->account_number]) }}"
                                               data-toggle="tooltip"
                                               class="btn btn-light btn-sm" title="@lang('client.edit')">
                                                <i class="fa fa-edit"></i></a>
                                            <button class="btn btn-light btn-sm" title="@lang('client.delete')"
                                                    type="button" data-toggle-tooltip
                                                    data-toggle="modal"
                                                    data-target="#deleteClient-{{ $client->account_number }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        @component('layouts.components.deleteItem', [
                                            'name' => 'client',
                                            'id' => $client->account_number,
                                            'action' => route('clients.destroy', [$client])
                                        ])@endcomponent
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection