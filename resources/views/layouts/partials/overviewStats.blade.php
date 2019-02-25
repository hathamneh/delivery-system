<div class="row overview-cards">
    <div class="col-md-{{ isset($statistics->achievement) ? "2" : "3" }}">
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
                    <small class="previous-value">(Previous period: {{ $statistics->shipments['previous'] }}
                        )
                    </small>
                </div>
            </div>

        </div>
    </div>
    @if(isset($statistics->achievement))
        <div class="col-md-2">
            <div class="card overview-cards-item">
                <div class="card-header d-flex">
                    <h3 class="card-title">@lang('courier.achievement')</h3>
                </div>
                <div class="card-body">
                    <div class="current-value">{{ $statistics->achievement['current'] }}</div>
                    <div class="overview-meta">
                        <small class="previous-value">(Previous
                            period: {{ $statistics->achievement['previous'] }})
                        </small>
                    </div>
                </div>

            </div>
        </div>
    @endif
    <div class="col-md-{{ isset($statistics->achievement) ? "2" : "3" }}">
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

<div class="container-fluid mt-3 p-xs-0">
    <h3>Shipment Statuses</h3>
    <div class="row">
        <div class="col-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                @php $i = 0; @endphp
                @foreach($statistics->statuses['values'] as $status => $values)
                    <a class="nav-link {{ $i++ > 0 ?: "show active" }}" id="v-pills-{{ $status }}-tab"
                       data-toggle="pill" href="#v-pills-{{ $status }}"
                       role="tab" aria-controls="v-pills-{{ $status }}"
                       aria-selected="true">{{ $values['label'] }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent">
                @php $i = 0; @endphp
                @foreach($statistics->statuses['values'] as $status => $values)
                    <div class="tab-pane fade {{ $i++ > 0 ?: "show active" }}" id="v-pills-{{ $status }}"
                         role="tabpanel"
                         aria-labelledby="v-pills-{{ $status }}-tab">
                        <canvas id="{{ $status }}Chart" width="900" height="400"></canvas>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


</div>

