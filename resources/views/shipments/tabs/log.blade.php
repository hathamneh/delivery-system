<div class="container">
    <h3>Shipment Change Log</h3>
    @if($shipment->revisionHistory->count())
    <ul class="list-group shipment-history shipment-log flex-column-reverse mt-3">
        @foreach($shipment->revisionHistory as $history)
            @php /** @var \Venturecraft\Revisionable\Revision $history */ @endphp
            <li class="list-group-item">
                <small class="history-date">{{ $history->created_at->toDayDateTimeString() }}</small>
                {!! $history->userResponsible() instanceof App\User ? '<small>By '.$history->userResponsible()->username . '</small>' : '' !!}
                <div class="font-weight-bold py-2">
                    @if($history->key == 'created_at' && !$history->old_value)
                        Shipment has been created
                    @else
                        {{ trans('shipment.'.$history->fieldName()) }} from `<u>{{ $history->oldValue() }}</u>`
                        to `<u>{{ $history->newValue() }}</u>`
                    @endif
                </div>
            </li>

        @endforeach
    </ul>

    @else
        <div class="py-4 px-1 text-center border-dark">No history!</div>
    @endif
</div>