<h3>Shipment History</h3>
@if($shipment->revisionHistory->count())
    <ul class="list-group shipment-history flex-column-reverse mt-3">
        @foreach($shipment->revisionHistory as $history)
            @if($history->key == 'created_at' && !$history->old_value)
                <li class="list-group-item">Shipment created at <span
                            class="badge badge-secondary">{{ $history->newValue() }}</span></li>
            @else
                <li class="list-group-item">
                    {{ $history->fieldName() == "status" ? ucfirst($history->fieldName()) : ucfirst(trans("shipment.".$history->fieldName())) }}
                    changed
                    from <span class="badge badge-secondary">{{ $history->oldValue() }}</span> to <span
                    class="badge badge-secondary">{{ $history->newValue() }}</span>
                    <br>
                    <small class="text-muted">{{ $history->userResponsible() != null && (Auth::check() && Auth::user()->isAdmin()) ? "By ". $history->userResponsible()->username . " at" : "At" }} {{ $history->created_at }}</small>
                </li>
            @endif
        @endforeach
    </ul>
@else
    <div class="py-4 px-1 text-center border-dark">No history!</div>
@endif