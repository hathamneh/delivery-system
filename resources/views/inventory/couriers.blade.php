@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('inventory.couriers') }}
@endsection

@section('pageTitle')
    <i class='fa-file'></i> @lang("inventory.couriers")
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
        <div class="row">
            <div class="col-sm-6 mx-auto">
                <form action="{{ route('inventory.courier') }}">
                    <div class="form-group row">
                        <label class="col-sm-auto control-label align-self-center mb-0">@lang('reports.select_courier')</label>
                        <div class="col-sm-8">
                            @component('couriers.search-courier-input',[
                                'name' => 'courier',
                                'placeholder' => trans('reports.select_courier'),
                                'value' => $courier->id ?? "",
                                'text' => $courier->name ?? "",
                            ]) @endcomponent
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-dark w-100">Go <i class="fa-play ml-1"></i></button>
                        </div>

                    </div>

                </form>
            </div>
        </div>

        @isset($inventory)
            @php /** @var \App\Inventory $inventory */ @endphp
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="shipments-tab" data-toggle="tab" href="#shipments" role="tab"
                       aria-controls="shipments"
                       aria-selected="true">His Shipments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="clients-tab" data-toggle="tab" href="#clients" role="tab"
                       aria-controls="clients" aria-selected="false">Delivered For Clients</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active p-3" id="shipments" role="tabpanel" aria-labelledby="shipments-tab">
                    @include('shipments.table', ['shipments' => $inventory->shipments()])
                </div>
                <div class="tab-pane p-3" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                    <div class="table-responsive py-2 px-1">
                        <table class="table table-hover dataTable">
                            <thead>
                            <tr>
                                <th>@lang('client.account_number')</th>
                                <th>@lang('client.trade_name')</th>
                                <th>@lang('client.shipments')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inventory->clients() as $client)
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
            </div>

        @endisset
    </div>
@endsection