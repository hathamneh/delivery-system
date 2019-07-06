<nav class="nav inner-nav">
    <a href="{{ route('clients.show', ['client'=>$client, 'tab'=>'statistics']) }}"
       class="{{ $tab != "statistics" ?: "active" }}"><i class="fa-chart-line"></i> @lang('client.statistics')</a>

    <a href="{{ route('clients.show', ['client'=>$client, 'tab'=>'shipments']) }}"
       class="{{ $tab != "shipments" ?: "active" }}"><i class="fa-shipment"
        ></i> @lang('client.shipments') <div class="badge badge-info">{{ $shipmentsCount }}</div></a>

    <a href="{{ route('clients.show', ['client'=>$client, 'tab'=>'pickups']) }}"
       class="{{ $tab != "pickups" ?: "active" }}"><i class="fa-shopping-bag"
        ></i> @lang('client.pickups') <div class="badge badge-info">{{ $pickupsCount }}</div></a>

    <a href="{{ route('clients.zones.index', ['client'=>$client]) }}"
       class="{{ $tab != "zones" ?: "active" }}"><i class="fa-map-marker-alt"></i> @lang('client.zones')</a>

    <a href="{{ route('clients.services.index', ['client'=>$client]) }}"
       class="{{ $tab != "services" ?: "active" }}"><i class="fa-handshake"></i> @lang('client.services')</a>

    <a href="{{ route('clients.edit', ['client'=>$client]) }}"
       class="{{ $tab != "edit" ?: "active" }}"><i class="fa-cogs"></i> @lang('client.properties')</a>
</nav>