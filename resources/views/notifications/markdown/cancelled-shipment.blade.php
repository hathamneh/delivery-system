Dear {{ $client->trade_name }} / {{ $client->name }}

Unfortunately! We would like to inform you that your shipment ({{ $shipment->waybill }}) has been **cancelled** by the consignee for the reason **{{ $shipment->status_notes }}**.

Please contact us on {{ Setting::get('company.telephone') }} to take the right action regarding this issue.