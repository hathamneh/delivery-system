<div class="p-2">
    <div class="form-group">
        <label for="filter_status">@lang('shipment.status')</label>
        <select id="filter_status" class="form-control select2 w-100" multiple data-style="popover-select2"
                data-placeholder="Choose status">
            @foreach($statuses as $status)
                @php /** @var \App\Status $status */ @endphp
                @if(in_array('returned',$applied['types']) && !in_array('returned', json_decode($status->groups)))
                    @continue
                @endif
                <option value="{{ $status->name }}" {{ in_array($status->name, $applied['scope']) ? "selected" : "" }}
                >@lang("shipment.statuses.{$status->name}.name") ({{ $status->s_count }})
                </option>

            @endforeach
        </select>
    </div>
    <form action="{{ request()->getRequestUri() }}" method="get">
        <input type="hidden" name="start" value="{{ $startDate }}">
        <input type="hidden" name="end" value="{{ $endDate }}">
        @if(auth()->user()->isAdmin())
            @if(!isset($client))
                <div class="form-group">
                    <label for="filter_client">@lang('client.account_number') / @lang('client.national_id')</label>
                    <input type="text" class="form-control" name="filters[client]" id="filter_client"
                           placeholder="Enter Value"
                           value="{{ $applied['client'] }}">
                </div>
            @endif
            <div class="form-group">
                <label for="filter_service">@lang('Service')</label>
                <select name="filters[service]" id="filter_service" class="form-control">
                    <option value="">None</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $service->id === $applied['service'] ? "selected" : "" }}>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="filter_assignment">@lang('Assignment')</label>
                <select name="filters[assignment]" id="filter_assignment" class="form-control">
                    <option value="all" {{ !isset($applied['assignment']) || $applied['assignment'] === 'all' ? 'selected' : '' }}>
                        All
                    </option>
                    <option value="assigned" {{ $applied['assignment'] === 'assigned' ? 'selected' : '' }}>Assigned
                        Only
                    </option>
                    <option value="not_assigned" {{ $applied['assignment'] === 'not_assigned' ? 'selected' : '' }}>Not
                        Assigned Only
                    </option>
                </select>
            </div>
            <input type="hidden" name="filters[types]" value="{{ join(',', $applied['types']) }}">
        @endif
        <input type="hidden" name="filters[scope]" value="{{ join(',', $applied['scope']) }}">
        <button class="btn btn-sm btn-secondary" type="submit">Apply</button>
    </form>
</div>