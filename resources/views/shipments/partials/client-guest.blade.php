<div class="col-md-6 shipment-client">
    <h3 class="mt-5 font-weight-bold">@lang('shipment.client_info')</h3>
    <div class="card">
        <div class="card-body">
            <div class="shipment-client_name d-flex align-items-center">
                {{ $shipment->client->trade_name }}
                <small class="badge badge-warning ml-auto" style="font-size: 1rem;">Not Registered Client</small>
            </div>
            <div class="mt-3">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th style="width: 30%;">@lang('client.national_id')</th>
                        <td>{{ $shipment->client->national_id }}</td>
                    </tr>
                    <tr>
                        <th>@lang('client.phone')</th>
                        <td>{{ $shipment->client->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>@lang('client.country')</th>
                        <td>{{ $shipment->client->country }}</td>
                    </tr>
                    <tr>
                        <th>@lang('client.city')</th>
                        <td>{{ $shipment->client->city }}</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>