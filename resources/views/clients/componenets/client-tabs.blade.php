<nav class="nav inner-nav">
    <a href="{{ route('clients.show', ['client'=>$client, 'tab'=>'statistics']) }}"
       class="{{ $tab != "statistics" ?: "active" }}"><i class="fa-chart-line"></i> @lang('client.statistics')</a>

    <a href="{{ route('clients.show', ['client'=>$client, 'tab'=>'shipments']) }}"
       class="{{ $tab != "shipments" ?: "active" }}"><i class="fa-shipment"></i> @lang('client.shipments')</a>

    <a href="{{ route('clients.show', ['client'=>$client, 'tab'=>'pickups']) }}"
       class="{{ $tab != "pickups" ?: "active" }}"><i class="fa-shopping-bag"></i> @lang('client.pickups')</a>

    <a href="{{ route('clients.edit', ['client'=>$client]) }}"
       class="{{ $tab != "edit" ?: "active" }}"><i class="fa-cogs"></i> @lang('client.properties')</a>
</nav>