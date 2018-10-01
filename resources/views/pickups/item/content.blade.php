<small class="text-muted">@lang('client.trade_name')</small>
<h3>
    @can('view', \App\Client::class)
        <a href="{{ route('clients.show', ['client' => $pickup->client->account_number]) }}">{{ $pickup->client->trade_name }}</a>
    @else
        {{ $pickup->client->trade_name }}
    @endcan
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
    @lang('courier.single'): <b><a
                href="{{ route('couriers.show', ['courier'=>$pickup->courier->id]) }}">{{ $pickup->courier->name }}</a></b>
    |
    @lang('pickup.identifier'): <b>{{ $pickup->identifier }}</b>
</span>

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
        <li class="list-group-item">
            <span class="meta-label">
                <i class="fa-clock2"></i> @lang('pickup.available_time'):
            </span>
            <div class="meta-value">
                <div>
                    <span class="text-muted mr-2">From:</span> {{ $pickup->available_date_start }}
                    <span class="badge badge-dark">{{ $pickup->available_time_start }}</span>
                </div>
                <div>
                    <span class="text-muted mr-2">To:</span> {{ $pickup->available_date_end }}
                    <span class="badge badge-dark">{{ $pickup->available_time_end }}</span>
                </div>
            </div>
        </li>
        @if(!auth()->user()->isCourier())
            <li class="list-group-item">
                <span class="meta-label">
                    <i class="fa-truck"></i> @lang('courier.phone'):
                </span>
                <span class="meta-value">
                    {{ $pickup->courier->phone_number }}
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
                {{ $pickup->address_text }}
                @if(!is_null($pickup->address_maps))
                    <a href="{{ $pickup->address_maps }}">See on google maps</a>
                @endif
            </span>
        </li>
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
</div>