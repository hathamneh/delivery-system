<div class="col-md-6 shipment-client">
    <h3 class="mt-5 font-weight-bold">@lang('shipment.client_info')</h3>
    <div class="card">
        <div class="card-body">
            <div class="shipment-client_name d-flex align-items-center">
                {{ $shipment->client->trade_name }}
                <a href="{{ route('clients.show', ['client' => $shipment->client]) }}"
                   class="btn btn-sm btn-secondary ml-auto">
                    <i class="fa-arrow-circle-right"></i> @lang('client.go_to_dashboard', ['client' => $shipment->client->trade_name])
                </a>

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