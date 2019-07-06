<tr>
    <th style="width: 30%;">@lang('client.national_id')</th>
    <td>{{ $shipment->guest->national_id }}</td>

    <th>@lang('client.phone')</th>
    <td>{{ $shipment->guest->phone_number }}</td>
</tr>
<tr>
    <th>@lang('client.country')</th>
    <td>{{ $shipment->guest->country }}</td>

    <th>@lang('client.city')</th>
    <td>{{ $shipment->guest->city }}</td>
</tr>
