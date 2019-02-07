<tr>
    <th style="width: 30%;">@lang('client.account_number')</th>
    <td>{{ $shipment->client->account_number }}</td>

    <th>@lang('client.name')</th>
    <td>{{ $shipment->client->name }}</td>
</tr>
<tr>
    <th>@lang('client.phone')</th>
    <td>{{ $shipment->client->phone_number }}</td>
    <th>@lang('client.address')</th>
    <td>{{ $shipment->client->address_country }} - {{ $shipment->client->address_city }}
        <br>{{ $shipment->client->address_sub }}
        @if($shipment->client->address_maps)
            <br><a href="{{ $shipment->client->address_maps }}">See on Google Maps</a>
        @endif
    </td>
</tr>
