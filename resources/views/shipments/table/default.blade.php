<div class="shipments-table">
    <table class="table table-hover {{ isset($dataTable) && $dataTable == false ?: "dataTable" }} table-selectable">
        <thead>
        <tr>
            <th>
                <div class="custom-control custom-checkbox" title="@lang('common.selectAll')">
                    <input type="checkbox" class="custom-control-input" id="selectAll">
                    <label class="custom-control-label" for="selectAll"></label>
                </div>
            </th>
            <th>@lang('shipment.waybill')</th>
            <th>@lang('client.trade_name')</th>
            <th>@lang('client.name')</th>
            <th>@lang('shipment.client_account_number')</th>
            <th>@lang('shipment.created_by')</th>
            <th>@lang('shipment.consignee_name')</th>
            <th>@lang('shipment.phone_number')</th>
            <th>@lang('shipment.address')</th>
            <th>@lang('shipment.address_sub_text')</th>
            <th>@lang('shipment.pieces')</th>
            <th>@lang('shipment.package_weight')</th>
            <th>@lang('shipment.shipment_value')</th>
            <th>@lang('shipment.service_types.label')</th>
            <th>@lang('shipment.extra_services')</th>
            <th>@lang('shipment.status')</th>
            <th>@lang('shipment.client_notes')</th>
            <th>@lang('shipment.internal_notes')</th>
            <th>@lang('shipment.external_notes')</th>
            <th>@lang('shipment.client_paid')</th>
            <th>@lang('shipment.courier_cashed')</th>
            <th>@lang('shipment.statuses.returned.name')?</th>
        </tr>
        </thead>
        <tbody>
        @foreach($shipments as $shipment)
            @php /** @var \App\Shipment $shipment */ @endphp
            <tr title="Open shipment details" data-id="{{ $shipment->id }}"
                class="{{ !is_null($shipment->courier) ? "courier-assigned" : "" }}">
                <td>
                    <div class="custom-control custom-checkbox" title="@lang('common.select')">
                        <input type="checkbox" class="custom-control-input" value="{{ $shipment->id }}" id="select_{{ $shipment->id }}">
                        <label class="custom-control-label" for="select_{{ $shipment->id }}"></label>
                    </div>
                </td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->waybill }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->is_guest ? $shipment->guest->trade_name : $shipment->client->trade_name }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->is_guest ? "GUEST" : $shipment->client->name }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->is_guest ? $shipment->guest->national_id : $shipment->client_account_number }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">By {{ optional($shipment->createdBy)->username ?? "unspecified" }} at {{ $shipment->created_at->format("M d, Y - h:i A") }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->consignee_name }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->phone_number }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->address->name }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->address_sub_text }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->pieces }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->package_weight }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ fnumber($shipment->shipment_value) }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ trans('shipment.service_types.' . $shipment->service_type) }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->services->pluck('short_name')->implode(', ') }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">
                    <div data-toggle="tooltip" title="{{ trans("shipment.statuses.{$shipment->status->name}.description") }}">
                        {{ trans("shipment.statuses.{$shipment->status->name}.name") }}
                    </div>
                </td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ optional($shipment->client)->note_for_courier }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->internal_notes }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{{ $shipment->external_notes }}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{!! $shipment->client_paid ? '<i class="fa-check"></i>' : '<i class="fa-times"></i>' !!}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{!! $shipment->courier_cashed ? '<i class="fa-check"></i>' : '<i class="fa-times"></i>' !!}</td>
                <td data-href="{{ route('shipments.show', ['shipment' => $shipment->id]) }}">{!! $shipment->isReturned() ? '<i class="fa-check"></i>' : '<i class="fa-times"></i>' !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>