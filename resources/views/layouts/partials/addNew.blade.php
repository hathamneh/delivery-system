<div class="card mt-4">
    <div class="card-body add-new-buttons">
        <div class="d-inline-block mr-3">
            <i class="fa-plus mr-2"></i><b>Add New</b>
        </div>

        <div class="btn-group btn-group-lg">
            @can('create', \App\Shipment::class)
                <a href="{{ route('shipments.create') }}" class="btn"><i
                            class="fa-shipment"></i> Shipment</a>
            @endcan
            @can('create', \App\Pickup::class)
                <a href="{{ route('pickups.create') }}" class="btn"><i
                            class="fa-shopping-bag"></i> Pickup</a>
            @endcan
            @if(auth()->user()->isAuthorized("notes", \App\Role::UT_CREATE))
                <a href="{{ route('notes.create') }}" class="btn"><i
                            class="fa-sticky-note"></i> Note</a>
            @endif
            @can('create', \App\Courier::class)
                <a href="{{ route('couriers.create') }}" class="btn"><i
                            class="fa-truck"></i> Courier</a>
            @endcan
            @can('create', \App\Client::class)
                <a href="{{ route('clients.create') }}" class="btn"><i
                            class="fa-user-tie"></i> Client</a>
            @endcan
            @can('create', \App\Zone::class)
                <a href="{{ route('zones.create') }}" class="btn"><i
                            class="fa-map-marker-alt"></i> Zone</a>
            @endcan
        </div>
    </div>
</div>