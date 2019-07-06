@php /** @var \App\Shipment $shipment */ @endphp
Dear {{ $client->trade_name }} / {{ $client->name }}

We would like to inform you that your shipment ({{ $shipment->waybill }}) will be sent back to our office ({{ $shipment->branch->name }}) as the consignee asked to collect it from our office

Please contact us on {{ Setting::get('company.telephone') }} if you need more details.