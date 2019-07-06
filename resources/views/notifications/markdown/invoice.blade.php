@php /** @var \App\Invoice $invoice */
/** @var \App\Client $client */
/** @var \App\Shipment $shipment */
@endphp
Dear {{ $client->trade_name }} / {{ $client->name }}

Thank you for the great partnership!

Please find the attached invoice for your account number for period
from {{ $invoice->period }}.


This invoice will be considered correct unless we receive notice of exception within 15 days.