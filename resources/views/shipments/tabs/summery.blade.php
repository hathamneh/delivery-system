@php /** @var \App\Shipment $shipment */ @endphp

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card mt-4 mx-2">
                <div class="card-header">
                    <h3 class="m-0">Shipment Accounting Summery</h3>
                </div>
                <div class="card-body">
                    <div class="shipment-cost">
                        <div class="shipment-cost__label">@lang('shipment.price_of_address')</div>
                        <div class="dots"></div>
                        <span class="shipment-cost__currency">@lang('common.jod')</span>
                        <div class="shipment-cost__value">
                            {{ number_format((float)$shipment->price_of_address, 2, '.', '') }}
                        </div>
                    </div>
                    <div class="shipment-cost">
                        <div class="shipment-cost__label">@lang('shipment.fees')</div>
                        <div class="dots"></div>
                        <span class="shipment-cost__currency">@lang('common.jod')</span>
                        <div class="shipment-cost__value">
                            {{ number_format((float)$shipment->extra_fees, 2, '.', '') }}
                        </div>
                    </div>
                    <div class="shipment-cost">
                        <div class="shipment-cost__label">@lang('shipment.services_cost')</div>
                        <div class="dots"></div>
                        <span class="shipment-cost__currency">@lang('common.jod')</span>
                        <div class="shipment-cost__value">
                            {{ number_format((float)$shipment->services_cost, 2, '.', '') }}
                        </div>
                    </div>
                    <div class="shipment-cost summery-border">
                        <div class="shipment-cost__label">@lang('shipment.delivery_cost')</div>
                        <div class="dots"></div>
                        <span class="shipment-cost__currency">@lang('common.jod')</span>
                        <div class="shipment-cost__value">
                            {{ number_format((float)$shipment->delivery_cost, 2, '.', '') }}
                        </div>
                    </div>
                    <div class="shipment-cost mt-1">
                        <div class="shipment-cost__label">@lang('shipment.shipment_value')</div>
                        <div class="dots"></div>
                        <span class="shipment-cost__currency">@lang('common.jod')</span>
                        <div class="shipment-cost__value">
                            {{ number_format((float)$shipment->shipment_value, 2, '.', '') }}
                        </div>
                    </div>
                    <div class="shipment-cost summery-border summery-bold">
                        <div class="shipment-cost__label">@lang('shipment.total')</div>
                        <div class="dots"></div>
                        <span class="shipment-cost__currency">@lang('common.jod')</span>
                        <div class="shipment-cost__value">
                            {{ number_format((float)$shipment->total, 2, '.', '') }}
                        </div>
                    </div>
                    <div class="shipment-cost mt-2">
                        <div class="shipment-cost__label">@lang('shipment.actual_paid')</div>
                        <div class="dots"></div>
                        <span class="shipment-cost__currency">@lang('common.jod')</span>
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
        <div class="col-md-6 shipment-client">
            <div class="card mt-4  mx-2">
                <div class="card-header d-flex align-items-center">
                    <h3 class="m-0">@lang('shipment.client_info')</h3>
                    <a href="{{ route('clients.show', ['client' => $shipment->client]) }}" class="btn btn-sm btn-secondary ml-auto">
                        <i class="fa-arrow-circle-right"></i> @lang('client.go_to_dashboard', ['client' => $shipment->client->trade_name])</a>
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
    </div>

</div>

