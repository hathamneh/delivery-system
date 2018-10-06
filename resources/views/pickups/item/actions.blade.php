@can('delete', $pickup)
    @component('layouts.components.deleteItem', [
                        'name' => 'pickup',
                        'id' => $pickup->id,
                        'action' => route('pickups.destroy', [$pickup])
                    ])@endcomponent



@endcan
@if(auth()->user()->isCourier() || auth()->user()->isAdmin())
    @component('bootstrap::modal',[
            'id' => 'pickupActionsModal-' . $pickup->id
        ])
        @slot('title')
            Pickup Actions
        @endslot
        <form action="{{ route('pickups.actions', [$pickup])  }}" method="post" class="pickup-actions-form">
            {{ csrf_field() }}
            {{ method_field('put') }}

            <div class="form-group pickup-statuses">
                <b class="mb-3 d-block">Please choose:</b>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="completed-{{ $pickup->id }}" name="status" value="completed" required
                           class="custom-control-input">
                    <label class="custom-control-label" for="completed-{{ $pickup->id }}">@lang('pickup.completed')</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="declined_client-{{ $pickup->id }}" name="status" value="declined_client" required
                           class="custom-control-input">
                    <label class="custom-control-label" for="declined_client-{{ $pickup->id }}">@lang('pickup.declined') -
                        Cancelled by client</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="declined_dispatcher-{{ $pickup->id }}" name="status" value="declined_dispatcher"
                           required
                           class="custom-control-input">
                    <label class="custom-control-label" for="declined_dispatcher-{{ $pickup->id }}">@lang('pickup.declined') -
                        Cancelled by dispatcher</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="declined_not_available-{{ $pickup->id }}" name="status"
                           value="declined_not_available" required
                           class="custom-control-input">
                    <label class="custom-control-label"
                           for="declined_not_available-{{ $pickup->id }}">@lang('pickup.declined') - Client not
                        available</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="client_rescheduled-{{ $pickup->id }}" name="status" value="client_rescheduled"
                           required data-original-time="{{ $pickup->available_day }} from {{ $pickup->time_start }} to {{ $pickup->time_end }}"
                           class="custom-control-input"
                           data-message="Kindly inform us about the requested time and any additional details">
                    <label class="custom-control-label" for="client_rescheduled-{{ $pickup->id }}">Client rescheduled</label>
                </div>
            </div>

            <div class="step-2">
                <div class="form-group actualPackages-input" style="display: none;">
                    <label for="actualPackages-{{ $pickup->id }}">@lang('pickup.actual_packages_number')</label>
                    <input type="number" name="actualPackages" id="actualPackages-{{ $pickup->id }}"
                           class="form-control" required min="1">
                </div>
                <div class="newTime-input" style="display: none;">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="available_day-{{ $pickup->id }}">@lang('pickup.available_time')</label>
                            <input type="text" name="available_day" id="available_day-{{ $pickup->id }}"
                                   value="{{ isset($pickup) ? $pickup->available_day : old('available_time') }}"
                                   class="form-control datetimepicker">
                        </div>
                        <div class="form-group col-6">
                            <label for="time_start-{{ $pickup->id }}">From:</label>
                            <input type="text" name="time_start" id="time_start-{{ $pickup->id }}"
                                   value="{{ isset($pickup) ? $pickup->time_start : old('available_time') }}"
                                   class="form-control timepicker">
                        </div>
                        <div class="form-group col-6">
                            <label for="time_end-{{ $pickup->id }}">To:</label>
                            <input type="text" name="time_end" id="time_end-{{ $pickup->id }}"
                                   value="{{ isset($pickup) ? $pickup->time_end : old('available_time') }}"
                                   class="form-control timepicker">
                        </div>
                    </div>
                </div>
                <div class="form-group reasons-input">
                    <label for="reasons-{{ $pickup->id }}">@lang('pickup.external_notes'):</label>
                    <textarea name="reasons" id="reasons-{{ $pickup->id }}" class="form-control"
                              data-target-for="statusSuggs"
                              placeholder="@lang('pickup.external_notes')"></textarea>
                    <div class="suggestions" id="statusSuggs" style="display: none;">
                        <button type="button" class="suggestions-item">No answer</button>
                        <button type="button" class="suggestions-item">Mobile switched off</button>
                        <button type="button" class="suggestions-item">No coverage</button>
                        <button type="button" class="suggestions-item">Transferred calls</button>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex flex-row-reverse w-100">
                <button class="btn btn-primary ml-auto" type="submit"><i
                            class="fa fa-save"></i> @lang('pickup.update')
                </button>

                <button class="btn btn-outline-secondary"
                        data-dismiss="modal">@lang('common.cancel')</button>
            </div>
        </form>

    @endcomponent
@endif