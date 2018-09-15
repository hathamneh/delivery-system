<div class="card">
    <div class="card-header">
        <h4 class="m-0 mb-3"><b style="font-weight: bolder;">{{ $selected->name }}</b></h4>
        <ul class="nav nav-tabs selectedZone-nav card-header-tabs nav-fill">
            <li class="nav-item">
                <a class="nav-link {{ $zoneTab != "addresses" ?: "active" }}"
                   href="{{ route('clients.addresses.index', ['client' => $client, 'zone' => $selected]) }}">Addresses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $zoneTab != "props" ?: "active" }}"
                   href="{{ route('clients.zones.show', ['client' => $client, 'zone' => $selected]) }}">Properties</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        @includeWhen($zoneTab == "props", 'clients.zones.properties')
        @includeWhen($zoneTab == "addresses", 'clients.zones.addresses')

    </div>
</div>