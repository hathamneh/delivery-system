Dear {{ $client->trade_name }} / {{ $client->name }}

We would like to inform you that the consignee the consignee has rescheduled receiving shipment ({{ $shipment->waybill }}) for the reason **{{ $shipment->status_notes }}**.

Please contact us on {{ Setting::get('company.telephone') }} to take the right action regarding this issue.