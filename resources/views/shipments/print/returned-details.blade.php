@php /** @var \App\Shipment $shipment */ @endphp

<table class="table table-bordered">
    <tr>
        <th style="vertical-align: middle;">
            @lang('shipment.waybill'):
        </th>
        <td colspan="3"><b style="font-size: 1.25rem;">{{ $shipment->waybill }}</b></td>
    </tr>
    <tr>
        <td colspan="4" class="divider"><i class="fa-user-tie"></i> Sender's Information</td>
    </tr>
    @include('shipments.print.sender-kangaroo')
    <tr>
        <td class="divider" colspan="4">
            <i class="fa-truck"></i> Consignee's information
        </td>
    </tr>
    <tr>
        <th>
            @lang('shipment.consignee_name')
        </th>
        <td>{{ $shipment->consignee_name }}</td>
        <th>
            @lang('shipment.phone_number')
        </th>
        <td>{{ $shipment->phone_number }}</td>
    </tr>
    <tr>
        <th>
            @lang('accounting.address')
        </th>
        <td>{{ $shipment->address->name }}</td>
        <th>
            @lang('shipment.address_maps_link')
        </th>
        <td>{{ $shipment->address_maps_link }}</td>
    </tr>
    <tr>
        <th>
            @lang('shipment.address_sub_text')
        </th>
        <td colspan="3">
            {{ $shipment->address_sub_text }}
        </td>
    </tr>
    <tr>
        <th>
            @lang('shipment.courier')
        </th>
        <td>{{ optional($shipment->courier)->name }}</td>
        <th>
            @lang('shipment.internal_notes')
        </th>
        <td>{{ $shipment->internal_notes }}</td>
    </tr>
    <tr>
        <td colspan="4" class="divider"><i class="fa-info-circle"></i> Shipment Information</td>
    </tr>
    <tr>
        <th>
            Return reason
        </th>
        <td>
            {{ $shipment->status_notes }}
        </td>
        <th>
            @lang('shipment.package_weight')
        </th>
        <td>{{ $shipment->package_weight }}</td>
    </tr>
    <tr>
        <th>
            @lang('shipment.pieces')
        </th>
        <td>{{ $shipment->pieces }}</td>
        <th>
            @lang('shipment.reference')
        </th>
        <td>{{ $shipment->reference }}</td>
    </tr>
</table>