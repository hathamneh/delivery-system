<div class="card">
    <div class="card-header">
        <i class="fa-arrow-circle-right mr-2"></i><b>Go To</b>
    </div>
    <div class="card-body">
        @can('index', \App\Shipment::class)
            <a href="{{ route('shipments.index') }}" class="quick-link">
                <div class="row">
                    <div class="icon">
                        <i class="fa-shipment bg-blue"></i>
                    </div>
                    <p class="text">Shipments</p>
                </div>
            </a>
        @endif
            @can('index', \App\Client::class)
            <a href="{{ route('clients.index') }}" class="quick-link">
                <div class="row">
                    <div class="icon">
                        <i class="fa-user-tie bg-purple"></i>
                    </div>
                    <p class="text">Clients</p>
                </div>
            </a>
        @endif
            @can('index', \App\Courier::class)
            <a href="{{ route('couriers.index') }}" class="quick-link">
                <div class="row">
                    <div class="icon">
                        <i class="fa-truck bg-blue"></i>
                    </div>
                    <p class="text">Couriers</p>
                </div>
            </a>
        @endif
            @can('index', \App\Pickup::class)
            <a href="{{ route('pickups.index') }}" class="quick-link">
                <div class="row">
                    <div class="icon">
                        <i class="fa-shopping-bag bg-orange"></i>
                    </div>
                    <p class="text">Pickups</p>
                </div>
            </a>
        @endif
            @can('index', \App\Note::class)
            <a href="{{ route('notes.index') }}" class="quick-link">
                <div class="row">
                    <div class="icon">
                        <i class="fa fa-sticky-note bg-pink"></i>
                    </div>
                    <p class="text">Notes</p>
                </div>
            </a>
        @endif
    </div>
</div>