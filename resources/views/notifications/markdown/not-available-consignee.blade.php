Dear {{ $client->trade_name }} / {{ $client->name }}

Unfortunately! We would like to inform you that the consignee is **not available** to receive the shipment ({{ $shipment->waybill }}) for the reason {{ $shipment->status_notes }} and an SMS sent.

Please contact us on {{ Setting::get('company.telephone') }} to take the right action regarding this issue.