<div class="shipments-table">
    <table class="table table-hover dataTable reports-table">
        <thead>
        <tr>
            <th>@lang('shipment.waybill')</th>
            <th>@lang('client.trade_name')</th>
            <th>@lang('shipment.client_account_number')</th>
            <th>@lang('shipment.consignee_name')</th>
            <th>@lang('shipment.delivery_date')</th>
            <th>@lang('shipment.couriers.label')</th>
            <th>@lang('shipment.address')</th>
            <th>@lang('shipment.service_types.label')</th>
            <th>@lang('shipment.status')</th>
            <th>@lang('shipment.shipment_value')</th>
            <th>@lang('shipment.delivery_cost')</th>
            <th>@lang('shipment.actual_paid')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($shipments as $shipment)
            @php /** @var \App\Shipment $shipment */ @endphp
            <tr data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}" title="Open shipment details">
                <td>{{ $shipment->waybill }}</td>
                <td>{{ $shipment->client->trade_name }}</td>
                <td>{{ $shipment->client_account_number }}</td>
                <td>{{ $shipment->consignee_name }}</td>
                <td>{{ $shipment->delivery_date }}</td>
                <td>{{ $shipment->courier->name }}</td>
                <td>{{ $shipment->address->name }}</td>
                <td>{{ trans($shipment->service_type) }}</td>
                <td><span title="{{ $shipment->status->description }}"
                          data-toggle="tooltip">@lang('shipment.statuses.'.$shipment->status->name)</span></td>
                <td>{{ fnumber($shipment->shipment_value) }}</td>
                <td>{{ fnumber($shipment->delivery_cost) }}</td>
                <td>{{ fnumber($shipment->actual_paid_by_consignee) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>