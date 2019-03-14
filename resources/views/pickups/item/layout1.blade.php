<small class="text-muted">@lang('client.trade_name')</small>
<h3>
    @if(Gate::check('index', \App\Client::class) && !is_null($pickup->client))
        <a href="{{ route('clients.show', ['client' => $pickup->client->account_number]) }}">{{ $pickup->client_name }}</a>
    @else
        {{ $pickup->client_name }}
    @endif
</h3>
<span>
    <span title="{{{ trans("pickup.expected_packages_number"). ": ". $pickup->expected_packages_number }}}"
          data-toggle="tooltip">
        @lang('pickup.expected'): <b
                class="px-2">{{ $pickup->expected_packages_number }}</b>
    </span> |&nbsp;
    <span title="{{{  $pickup->actual_packages_number ? trans("pickup.actual_packages_number").": ".$pickup->actual_packages_number : trans('pickup.not_picked_up_yet') }}}"
          data-toggle="tooltip">
        @lang('pickup.actual'): <b
                class="px-2">{{ $pickup->actual_packages_number ?? "?" }}</b>
    </span>
</span>
<br>
<span class="text-muted">
    @lang('courier.single'):
    @if(is_null($pickup->courier))
        <small class="badge badge-warning">-- None --</small>
    @else
        <b><a href="{{ route('couriers.show', ['courier'=>$pickup->courier->id]) }}">{{ $pickup->courier->name }}</a></b>
    @endif
    |
    @lang('pickup.identifier'): <b>{{ $pickup->identifier }}</b>
</span>
<hr class="my-2">
<span class="meta-label">
    <i class="fa-clock2"></i> @lang('pickup.available_time'): {{ $pickup->available_day }}
</span>
<div class="meta-value">
    <div>
        <span class="text-muted mr-1">From:</span>
        <span class="badge badge-dark">{{ $pickup->time_start }}</span>
        <span class="text-muted mr-1 ml-1">To:</span>
        <span class="badge badge-dark">{{ $pickup->time_end }}</span>
    </div>
</div>
<div class="pickup-meta collapse" id="pickupDetails_{{ $pickup->id }}">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <span class="meta-label">
                <i class="fa-shopping-bag"></i> @lang('pickup.pickup_from'):
            </span>
            <span class="meta-value">
                @lang('pickup.from_'.$pickup->pickup_from)
            </span>
        </li>
        @if(!auth()->user()->isCourier())
            <li class="list-group-item">
                <span class="meta-label">
                    <i class="fa-truck"></i> @lang('courier.phone'):
                </span>
                <span class="meta-value">
                    {{ optional($pickup->courier)->phone_number }}
                </span>
            </li>
        @endif
        <li class="list-group-item">
            <span class="meta-label">
                <i class="fa-user-circle2"></i> @lang('pickup.'.$pickup->pickup_from.'_phone'):
            </span>
            <span class="meta-value">
                {{ $pickup->phone_number }}
            </span>
        </li>
        <li class="list-group-item">
            <span class="meta-label">
                <i class="fa-map-marker-alt"></i> @lang('pickup.address'):
            </span>
            <span class="meta-value">
                {{ $pickup->pickup_address_text }}
                @if(!is_null($pickup->pickup_address_maps))
                    <a href="{{ $pickup->pickup_address_maps }}">See on google maps</a>
                @endif
            </span>
        </li>
        @if(!is_null($pickup->prepaid_cash))
            <li class="list-group-item">
                <span class="meta-label">
                    <i class="fa-dollar-sign"></i> @lang('pickup.prepaid_cash')
                </span>
                <span class="meta-value">
                    {{ $pickup->prepaid_cash }}
                </span>
            </li>
        @endif
        <li class="list-group-item">
            <span class="meta-label">@lang('pickup.external_notes'):</span>
            <br>
            <span class="meta-value">
                {{ $pickup->notes_external ?? "No notes" }}
            </span>
        </li>
        <li class="list-group-item list-group-item-warning">
            <span class="meta-label">@lang('pickup.internal_notes'):</span>
            <br>
            <span class="meta-value">
                {{ $pickup->notes_internal ?? "No notes" }}
            </span>
        </li>
    </ul>

    <div class="p-3">
        <h3>Pickup History</h3>
        @php $log = \Spatie\Activitylog\Models\Activity::forSubject($pickup)->get() @endphp
        @if($log->count())
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
    </div>
</div>