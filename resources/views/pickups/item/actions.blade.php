@can('delete', $pickup)
    @component('layouts.components.deleteItem', [
                        'name' => 'pickup',
                        'id' => $pickup->id,
                        'action' => route('pickups.destroy', [$pickup])
                    ])@endcomponent



@endcan
@if(auth()->user()->isCourier() || auth()->user()->isAdmin())
    @component('bootstrap::modal',[
            'id' => 'pickupActionsModal'
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
                    <input type="radio" id="completed" name="status" value="completed" required
                           class="custom-control-input">
                    <label class="custom-control-label" for="completed">@lang('pickup.completed')</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="declined_client" name="status" value="declined_client" required
                           class="custom-control-input">
                    <label class="custom-control-label" for="declined_client">@lang('pickup.declined') -
                        Cancelled by client</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="declined_dispatcher" name="status" value="declined_dispatcher"
                           required
                           class="custom-control-input">
                    <label class="custom-control-label" for="declined_dispatcher">@lang('pickup.declined') -
                        Cancelled by dispatcher</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="declined_not_available" name="status"
                           value="declined_not_available" required
                           class="custom-control-input">
                    <label class="custom-control-label"
                           for="declined_not_available">@lang('pickup.declined') - Client not
                        available</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="client_rescheduled" name="status" value="client_rescheduled"
                           required
                           class="custom-control-input"
                           data-message="Kindly inform us about the requested time and any additional details">
                    <label class="custom-control-label" for="client_rescheduled">Client rescheduled</label>
                </div>
            </div>

            <div class="step-2">
                <div class="form-group actualPackages-input" style="display: none;">
                    <label for="actualPackages">@lang('pickup.actual_packages_number')</label>
                    <input type="number" name="actualPackages" id="actualPackages"
                           class="form-control" required>
                </div>
                <div class="form-group newTime-input" style="display: none;">
                    <label for="available_time">New @lang('pickup.available_time')</label>
                    <input type="text" name="available_time" id="available_time"
                           class="form-control datetime-rangepicker" data-drp-drops="up" required>
                </div>
                <div class="form-group reasons-input">
                    <label for="reasons">@lang('pickup.external_notes'):</label>
                    <textarea name="reasons" id="reasons" class="form-control"
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