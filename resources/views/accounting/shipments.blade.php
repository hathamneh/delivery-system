<table class="table invoice-table table-bordered">
    <thead>
    <tr role="row" class="head-tr">
        <th class="">#</th>
        <th>@lang('accounting.hawb')</th>
        <th>@lang('accounting.status')</th>
        <th>@lang('accounting.delivery_date')</th>
        <th>@lang('accounting.address')</th>
        <th>@lang('accounting.service_type')</th>
        <th>@lang('accounting.weight')</th>
        <th>@lang('accounting.pieces')</th>
        <th>@lang('accounting.shipment_value')</th>
        <th>@lang('accounting.collected_value')</th>
        <th>@lang('accounting.base_charge')</th>
        <th>@lang('accounting.extra_fees')</th>
        <th>@lang('accounting.extra_services')</th>
        <th>@lang('accounting.net')</th>
    </tr>
    </thead>
    <tbody>
    @php $i = 0; @endphp
    @foreach($shipments as $shipment)
        @php /** @var \App\Shipment $shipment */ @endphp
        <tr>
            <td rowspan="2" class="separator-bottom">{{ ++$i }}</td>
            <td>{{ $shipment->waybill }}</td>
            <td>@lang("shipment.statuses.{$shipment->status->name}.name")</td>
            <td>{{ $shipment->delivery_date->toFormattedDateString() }}</td>
            <td>{{ $shipment->address->zone->name }}</td>
            <td>@lang("accounting.service_types.".$shipment->service_type)</td>
            <td>{{ $shipment->package_weight }}</td>
            <td>{{ $shipment->pieces }}</td>
            <td>{{ fnumber($shipment->shipment_value) }}</td>
            <td>{{ fnumber($shipment->actual_paid_by_consignee) }}</td>
            @if($shipment->isPriceOverridden())
                <td colspan="3">{{ fnumber($shipment->base_charge) }}</td>
            @else
                <td>{{ fnumber($shipment->base_charge) }}</td>
                <td>{{ fnumber($shipment->extra_fees) }}</td>
                <td>{{ fnumber($shipment->services_cost) }}</td>
            @endif
            <td class="font-weight-bold text-center separator-bottom"
                rowspan="2">{{ fnumber($shipment->net_amount) }}</td>
        </tr>
        <tr>
            <td colspan="12" class="light-bg separator-bottom">
                <div>
                    @lang('accounting.operational_details'):
                    <ul class="operational-details">
                        <li><b>@lang('accounting.consignee_info')
                                :</b> {{ $shipment->consignee_name }}
                            , {{ $shipment->phone_number }} , {{ $shipment->address->name }}</li>
                        @include('shipments.print.services')
                        @if($shipment->client_paid)
                            <li><b>@lang('shipment.client_paid')</b></li>
                        @endif
                        @if($shipment->courier_cashed)
                            <li><b>@lang('shipment.courier_cashed')</b></li>
                        @endif
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
