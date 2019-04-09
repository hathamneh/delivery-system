<div class="modal fade" id="pickupHistory-{{ $pickup->id }}" tabindex="-1" role="dialog"
     aria-labelledby="pickupHistory-{{ $pickup->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pickup Actions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="pickupHistoryTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="history-tab" data-toggle="tab" href="#history-{{ $pickup->id }}"
                           role="tab"
                           aria-controls="home" aria-selected="true">@lang('pickup.history')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="changelog-tab" data-toggle="tab" href="#changelog-{{ $pickup->id }}"
                           role="tab"
                           aria-controls="profile" aria-selected="false">@lang('pickup.change_log')</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="history-{{ $pickup->id }}" role="tabpanel"
                         aria-labelledby="history-tab">
                        <h3>Pickup History</h3>
                        @php $log = \Spatie\Activitylog\Models\Activity::forSubject($pickup)->get() @endphp
                        @if($log->count())
                            <ul class="list-group shipment-history shipment-log flex-column-reverse mt-3">
                                @foreach($log as $activity)
                                    @php /** @var \Spatie\Activitylog\Models\Activity $activity */ @endphp
                                    <li class="list-group-item">
                                        <small class="history-date">{{ $activity->created_at->toDayDateTimeString() }}</small>
                                        @if(auth()->user()->isAdmin())
                                            <small>By {{ optional($activity->causer)->display_name }}</small>
                                        @endif
                                        <div class="font-weight-bold py-2">{{ $activity->description }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="py-4 px-1 text-center border-dark">No history!</div>
                        @endif
                    </div>
                    <div class="tab-pane" id="changelog-{{ $pickup->id }}" role="tabpanel"
                         aria-labelledby="changelog-tab">
                        <h3>Pickup Change Log</h3>
                        @if($pickup->revisionHistory->count())
                            <ul class="list-group shipment-history shipment-log flex-column-reverse mt-3">
                                @foreach($pickup->revisionHistory as $history)
                                    @php /** @var \Venturecraft\Revisionable\Revision $history */ @endphp
                                    <li class="list-group-item">
                                        <small class="history-date">{{ $history->created_at->toDayDateTimeString() }}</small>
                                        {!! $history->userResponsible() instanceof App\User ? '<small>By '.$history->userResponsible()->display_name . '</small>' : '' !!}
                                        <div class="font-weight-bold py-2">
                                            @if($history->key == 'created_at' && !$history->old_value)
                                                Shipment has been created
                                            @else
                                                {{ trans('pickup.'.$history->fieldName()) }} from
                                                ` <u>{{ $history->oldValue() }}</u> `
                                                to ` <u>{{ $history->newValue() }}</u> `
                                            @endif
                                        </div>
                                    </li>

                                @endforeach
                            </ul>

                        @else
                            <div class="py-4 px-1 text-center border-dark">No change log!</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
