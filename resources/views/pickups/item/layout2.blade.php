<div class="pickup-meta">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <small class="text-muted">@lang('client.trade_name')</small>
            <h3>
                @can('index', \App\Client::class)
                    <a href="{{ route('clients.show', ['client' => $pickup->client->account_number]) }}">{{ $pickup->client->trade_name }}</a>
                @else
                    {{ $pickup->client->trade_name }}
                @endcan
            </h3>
        </li>
        <li class="list-group-item">
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
            <span class="meta-label">
                <i class="fa-phone"></i> @lang('pickup.'.$pickup->pickup_from.'_phone'):
            </span>
            <span class="meta-value">
                {{ $pickup->phone_number }}
            </span>
        </li>
        <li class="list-group-item">
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
        </li>
        <li class="list-group-item border-top">
            <span class="meta-label">
                <i class="fa-shopping-bag"></i> @lang('pickup.identifier'):
            </span>
            <span class="meta-value">
                {{ $pickup->identifier }}
            </span>
        </li>
    </ul>
</div>

<div class="pickup-meta collapse" id="pickupDetails_{{ $pickup->id }}">
    <ul class="list-group list-group-flush">
        <li class="list-group-item border-top">
            <span class="meta-label">
                <i class="fa-shopping-bag"></i> @lang('pickup.pickup_from'):
            </span>
            <span class="meta-value">
                @lang('pickup.from_'.$pickup->pickup_from)
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