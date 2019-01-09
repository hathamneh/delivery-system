<div class="shipments-table">
    <table class="table table-hover dataTable">
        <thead>
        <tr>
            <th>@lang('shipment.waybill')</th>
            <th>@lang('client.trade_name')</th>
            <th>@lang('client.name')</th>
            <th>@lang('shipment.client_account_number')</th>
            <th>@lang('shipment.create_at')</th>
            <th>@lang('shipment.consignee_name')</th>
            <th>@lang('shipment.phone_number')</th>
            <th>@lang('shipment.address_sub_text')</th>
            <th>@lang('shipment.pieces')</th>
            <th>@lang('shipment.package_weight')</th>
            <th>@lang('shipment.shipment_value')</th>
            <th>@lang('shipment.service_types.label')</th>
            <th>@lang('shipment.extra_services')</th>
            <th>@lang('shipment.status')</th>
            <th>@lang('shipment.internal_notes')</th>
            <th>@lang('shipment.external_notes')</th>
            <th>@lang('shipment.client_paid')</th>
            <th>@lang('shipment.courier_cashed')</th>
            <th>@lang('shipment.statuses.returned')?</th>
        </tr>
        </thead>
        <tbody>
        @foreach($shipments as $shipment)
            @php /** @var \App\Shipment $shipment */ @endphp
            <tr data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}" title="Open shipment details">
                <td>{{ $shipment->waybill }}</td>
                <td>{{ $shipment->is_guest ? $shipment->guest->trade_name : $shipment->client->trade_name }}</td>
                <td>{{ $shipment->is_guest ? "GUEST" : $shipment->client->name }}</td>
                <td>{{ $shipment->is_guest ? $shipment->guest->national_id : $shipment->client_account_number }}</td>
                <td>{{ $shipment->created_at->format("M d, Y - h:i A") }}</td>
                <td>{{ $shipment->consignee_name }}</td>
                <td>{{ $shipment->phone_number }}</td>
                <td>{{ $shipment->address_sub_text }}</td>
                <td>{{ $shipment->pieces }}</td>
                <td>{{ $shipment->package_weight }}</td>
                <td>{{ fnumber($shipment->shipment_value) }}</td>
                <td>{{ trans('shipment.service_types.' . $shipment->service_type) }}</td>
                <td>{{ $shipment->services->pluck('name')->implode(',') }}</td>
                <td>{{ trans('shipment.statuses.' . $shipment->status->name) }}</td>
                <td>{{ $shipment->internal_notes }}</td>
                <td>{{ $shipment->external_notes }}</td>
                <td>{{ $shipment->courier_cashed ? "Yes" : "No" }}</td>
                <td>{{ $shipment->client_paid ? "Yes" : "No" }}</td>
                <td>{{ $shipment->isReturned() ? "Yes" : "No" }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>