@php /** @var \App\Shipment $shipment */ @endphp

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="my-3">Summery</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <small>@lang('shipment.waybill'):</small>
                                <b>{{ $shipment->waybill }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('client.trade_name'):</small>
                                <b>{{ $shipment->client->trade_name }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('shipment.consignee_name'):</small>
                                <b>{{ $shipment->consignee_name }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('shipment.phone_number'):</small>
                                <b>{{ $shipment->phone_number }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('shipment.shipment_value'):</small>
                                <b>{{ $shipment->shipment_value }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('shipment.extra_services'):</small>
                                <b>{{ $shipment->services->implode('name', ', ') }}</b>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <small>@lang('shipment.pieces'):</small>
                                <b>{{ $shipment->pieces }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('shipment.address'):</small>
                                <b>{{ $shipment->address->name }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('shipment.address_sub_text'):</small>
                                <b>{{ $shipment->address_sub_text }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('shipment.address_sub_text'):</small>
                                <a href="{{ $shipment->address_maps_link }}">{{ $shipment->address_maps_link }}</a>
                            </li>
                            <li class="list-group-item list-group-item-warning">
                                <small>@lang('shipment.internal_notes'):</small>
                                <br> <b>{{ $shipment->internal_notes }}</b>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @if(!auth()->user()->isClient())
            <div class="col-md-6">
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="m-0">Shipment Accounting Summery</h3>
                    </div>
                    <div class="card-body">
                        <div class="shipment-cost">
                            <div class="shipment-cost__label">@lang('shipment.price_of_address')</div>
                            <div class="dots"></div>
                            <span class="shipment-cost__currency currency">@lang('common.jod')</span>
                            <div class="shipment-cost__value">
                                {{ number_format((float)$shipment->price_of_address, 2, '.', '') }}
                            </div>
                        </div>
                        <div class="shipment-cost">
                            <div class="shipment-cost__label">@lang('shipment.fees')</div>
                            <div class="dots"></div>
                            <span class="shipment-cost__currency currency">@lang('common.jod')</span>
                            <div class="shipment-cost__value">
                                {{ number_format((float)$shipment->extra_fees, 2, '.', '') }}
                            </div>
                        </div>
                        <div class="shipment-cost">
                            <div class="shipment-cost__label">@lang('shipment.services_cost')</div>
                            <div class="dots"></div>
                            <span class="shipment-cost__currency currency">@lang('common.jod')</span>
                            <div class="shipment-cost__value">
                                {{ number_format((float)$shipment->services_cost, 2, '.', '') }}
                            </div>
                        </div>
                        <div class="shipment-cost summery-border summery-bold">
                            <div class="shipment-cost__label">@lang('shipment.delivery_cost')</div>
                            <div class="dots"></div>
                            <span class="shipment-cost__currency currency">@lang('common.jod')</span>
                            <div class="shipment-cost__value">
                                {{ number_format((float)$shipment->delivery_cost, 2, '.', '') }}
                            </div>
                        </div>
                        <div class="shipment-cost mt-2">
                            <div class="shipment-cost__label">@lang('shipment.shipment_value')</div>
                            <div class="dots"></div>
                            <span class="shipment-cost__currency currency">@lang('common.jod')</span>
                            <div class="shipment-cost__value">
                                {{ number_format((float)$shipment->shipment_value, 2, '.', '') }}
                            </div>
                        </div>
                        <div class="shipment-cost mt-2">
                            <div class="shipment-cost__label">@lang('shipment.actual_paid')</div>
                            <div class="dots"></div>
                            <span class="shipment-cost__currency currency">@lang('common.jod')</span>
                            <div class="shipment-cost__value">
                                {{ number_format((float)$shipment->actual_paid_by_consignee, 2, '.', '') }}
                            </div>
                        </div>
                        <div class="shipment-cost summery-border">
                            <div class="shipment-cost__label">@lang('shipment.delivery_cost_lodger.label')</div>
                            <div class="dots"></div>
                            <div class="shipment-cost__value">
                                @lang("shipment.delivery_cost_lodger.".$shipment->delivery_cost_lodger)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(!auth()->user()->isCourier())
            <div class="col-md-6 shipment-client">
                <div class="card mt-4">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="m-0">@lang('shipment.client_info')</h3>
                        @if(!($shipment instanceof \App\GuestShipment))
                            <a href="{{ route('clients.show', ['client' => $shipment->client]) }}"
                               class="btn btn-sm btn-secondary ml-auto">
                                <i class="fa-arrow-circle-right"></i> @lang('client.go_to_dashboard', ['client' => $shipment->client->trade_name])
                            </a>
                        @else
                            <div class="badge badge-warning ml-auto">Guest Client</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="shipment-client_name">
                            {{ $shipment->client->trade_name }}
                        </div>
                        <div class="mt-3">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <th style="width: 30%;">@lang('client.account_number')</th>
                                    <td>{{ $shipment->client->account_number }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('client.name')</th>
                                    <td>{{ $shipment->client->name }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('client.phone')</th>
                                    <td>{{ $shipment->client->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('client.address')</th>
                                    <td>{{ $shipment->client->address_country }} - {{ $shipment->client->address_city }}
                                        <br>{{ $shipment->client->address_sub }}
                                        @if($shipment->client->address_maps)
                                            <br><a href="{{ $shipment->client->address_maps }}">See on Google Maps</a>
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>

</div>

