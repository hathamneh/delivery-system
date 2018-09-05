<div class="card">
    <div class="card-body">
        <div class="add-custom-zone-form">
            <form action="{{ route('clients.zones.store', ['client' => $client->account_number]) }}" method="post">
                {{ csrf_field() }}
                <div class="input-group">
                    <select name="zone_id" id="newCustomZoneSelect"
                            class="form-control border-secondary" onchange="$(this).closest('.input-group').find('button').prop('disabled', false)">
                        <option value="" disabled selected>Select Zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary add-custom-zone-btn" disabled title="Add custom zone from saved zones." data-toggle="tooltip"><i
                                    class="fa-plus mr-2"></i> Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @if(!$customZones->count())
            <p class="pt-5 text-muted text-center">
                No custom zones yet!
            </p>
        @endif
    </div>
    @if($customZones->count())
        <nav class="list-group customZones-list list-group-flush pb-3">
            @foreach($customZones as $customZone)
                <a href="{{ $customZone->url('show') }}" class="list-group-item list-group-item-action {{ !isset($selected) || $selected->id != $customZone->id ?: 'active' }}">{{ $customZone->name }}</a>
            @endforeach
        </nav>
    @endif

</div>