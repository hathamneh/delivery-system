<h3>Shipment History</h3>
@if(isset($log) && $log->count())
    <ul class="list-group shipment-history flex-column-reverse mt-3">
        @foreach($log as $activity)
            @php /** @var \Spatie\Activitylog\Models\Activity $activity */ @endphp
            <li class="list-group-item">
                <small class="history-date">{{ $activity->created_at->toDayDateTimeString() }}</small>
                @if(auth()->user()->isAdmin())
                    <small>By {{ optional($activity->causer)->username }}</small>
                @endif
                <div class="font-weight-bold py-2">{{ $activity->description }}</div>
            </li>
        @endforeach
    </ul>
@else
    <div class="py-4 px-1 text-center border-dark">No history!</div>
@endif