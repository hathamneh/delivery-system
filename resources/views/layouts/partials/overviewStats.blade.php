<div class="row overview-cards">
    <div class="col-md-3">
        <div class="card overview-cards-item">
            <div class="card-header d-flex">
                <h3 class="card-title">@lang('shipment.label')</h3>
            </div>
            <div class="card-body">
                <div class="current-value">{{ $statistics->shipments['current'] }}</div>
                <div class="overview-meta">
                    <div class="percentage-value {{ $statistics->shipments['state'] }}"><i
                                class="fa-arrow-{{ $statistics->shipments['state'] }}"></i> {{ $statistics->shipments['ratio'] }}
                        %
                    </div>
                    <small class="previous-value">(Previous period: {{ $statistics->shipments['previous'] }})</small>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-3">
        <div class="card overview-cards-item">
            <div class="card-header d-flex">
                <h3 class="card-title">@lang('pickup.label')</h3>
            </div>
            <div class="card-body">
                <div class="current-value">{{ $statistics->pickups['current'] }}</div>
                <div class="overview-meta">
                    <div class="percentage-value {{ $statistics->pickups['state'] }}"><i
                                class="fa-arrow-{{ $statistics->pickups['state'] }}"></i> {{ $statistics->pickups['ratio'] }}
                        %
                    </div>
                    <small class="previous-value">(Previous period: {{ $statistics->pickups['previous'] }})</small>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-3">
        <div class="card overview-cards-item">
            <div class="card-header d-flex">
                <h3 class="card-title">@lang('accounting.due_for')</h3>
            </div>
            <div class="card-body">
                @if(is_array($statistics->dueFor['current']))
                    <div class="current-value">{{ fnumber($statistics->dueFor['current']['share']) }}<span
                                class="currency">JOD</span></div>
                    <div class="overview-meta">
                        <div class="percentage-value {{ $statistics->dueFor['state'] }}"><i
                                    class="fa-arrow-{{ $statistics->dueFor['state'] }}"></i> {{ $statistics->dueFor['ratio'] }}
                            %
                        </div>
                        <small class="previous-value">(Previous period: <span
                                    class="currency">JOD</span>{{ $statistics->dueFor['previous']['share'] }})
                        </small>
                    </div>
                @else
                    <div class="current-value">{{ fnumber($statistics->dueFor['current']) }}<span
                                class="currency">JOD</span></div>
                    <div class="overview-meta">
                        <div class="percentage-value {{ $statistics->dueFor['state'] }}"><i
                                    class="fa-arrow-{{ $statistics->dueFor['state'] }}"></i> {{ $statistics->dueFor['ratio'] }}
                            %
                        </div>
                        <small class="previous-value">(Previous period: <span
                                    class="currency">JOD</span>{{ $statistics->dueFor['previous'] }})
                        </small>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <div class="col-md-3">
        <div class="card overview-cards-item">
            <div class="card-header d-flex">
                <h3 class="card-title">@lang('accounting.due_from')</h3>
            </div>
            <div class="card-body">
                <div class="current-value">{{ fnumber($statistics->dueFrom['current']) }}<span
                            class="currency">JOD</span></div>
                <div class="overview-meta">
                    <div class="percentage-value {{ $statistics->dueFrom['state'] }}"><i
                                class="fa-arrow-{{ $statistics->dueFrom['state'] }}"></i> {{ $statistics->dueFrom['ratio'] }}
                        %
                    </div>
                    <small class="previous-value">(Previous period: <span
                                class="currency">JOD</span>{{ $statistics->dueFrom['previous'] }})
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>
