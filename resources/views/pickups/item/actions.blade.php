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
                <label for="status" class="d-block">Change the status of the pickup:</label>
                <select name="status" id="status" class="form-control">
                    <option disabled selected>@lang('common.select')</option>
                    @foreach($statuses as $status)
                        @php /** @var \App\PickupStatus $status */ @endphp
                        <option value="{{ $status->name }}">@lang("pickup.statuses.{$status->name}")</option>
                    @endforeach
                </select>
            </div>

            <div class="step-2" style="display: none;">
                @if($pickup->is_guest)
                    <div class="form-group {{ implode(' ', $statusesOptions['completed']) }}">
                        <label for="prepaid_cash">@lang('How much did he pay?')</label>
                        <small class="form-control-feedback text-danger">This must match the value agreed on with the
                            customer.
                        </small>
                        <input type="number" data-type="number" step="any" name="prepaid_cash" id="prepaid_cash" class="form-control"
                               required
                               placeholder="Please enter a value" min="{{ $pickup->prepaid_cash }}"
                               max="{{ $pickup->prepaid_cash }}">
                    </div>
                @endif
                <div class="form-group {{ implode(' ', $statusesOptions['completed']) }}">
                    <label for="actualPackages-{{ $pickup->id }}">@lang('pickup.actual_packages_number')</label>
                    <input type="number" data-type="number" name="actualPackages" id="actualPackages-{{ $pickup->id }}"
                           class="form-control" required min="1" placeholder="Please enter a value">
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 {{ implode(' ', $statusesOptions['setAvailableTime']) }}">
                        <label for="available_day-{{ $pickup->id }}">@lang('pickup.available_time')</label>
                        <input type="text" data-type="text" name="available_day" id="available_day-{{ $pickup->id }}"
                               value="{{ isset($pickup) ? $pickup->available_day : old('available_time') }}"
                               class="form-control datetimepicker">
                    </div>
                    <div class="form-group col-6 {{ implode(' ', $statusesOptions['setAvailableTime']) }}">
                        <label for="time_start-{{ $pickup->id }}">From:</label>
                        <input type="text" data-type="text" name="time_start" id="time_start-{{ $pickup->id }}"
                               value="{{ isset($pickup) ? $pickup->time_start : old('available_time') }}"
                               class="form-control timepicker">
                    </div>
                    <div class="form-group col-6 {{ implode(' ', $statusesOptions['setAvailableTime']) }}">
                        <label for="time_end-{{ $pickup->id }}">To:</label>
                        <input type="text" data-type="text" name="time_end" id="time_end-{{ $pickup->id }}"
                               value="{{ isset($pickup) ? $pickup->time_end : old('available_time') }}"
                               class="form-control timepicker">
                    </div>
                </div>
                <div class="row">
                    @foreach($statusesOptions['select'] as $status)
                        @foreach($status->options['select'] as $name => $choices)
                            <div class="form-group col-12 {{ $status->name }}">
                                <label for="{{ $status->name . "_" . $name }}">@lang("shipment.statuses_options.{$name}")</label>
                                <select class="form-control"
                                        name="_{{ $name }}"
                                        id="{{ $status->name . "_" . $name }}">
                                    @foreach($choices as $choice)
                                        <option value="{{ $choice }}">{{ $choice }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                <div class="form-group all">
                    <label for="reasons-{{ $pickup->id }}">@lang('pickup.external_notes'):</label>
                    <textarea name="notes" id="notes-{{ $pickup->id }}" class="form-control"
                              placeholder="@lang('pickup.external_notes')"></textarea>
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

<form action="{{ route('pickups.assign', $pickup) }}" method="POST" id="assignCourierForm-{{ $pickup->id }}">
    @method('PUT')
    @csrf
    @component('bootstrap::modal',[
            'id' => 'assignCourierModal-' . $pickup->id
        ])
        @slot('title')
            @lang("pickup.assignCourierTitle")
        @endslot
        <div class="form-group">
            <label for="courier">@lang('courier.single')</label>
            @component('couriers.search-courier-input',[
                'id' => 'courier-' . $pickup->id,
                'name' => 'courier',
                'placeholder' => trans('courier.single'),
                'value' => optional($pickup->courier)->id ?? "",
                'text' => optional($pickup->courier)->name ?? "",
            ]) @endcomponent
        </div>

        @slot('footer')
            <div class="d-flex flex-row-reverse w-100">
                <button class="btn btn-primary" type="submit">@lang('shipment.assignCourier') <i
                            class="fa fa-arrow-right"></i>
                </button>
                <button class="btn btn-outline-secondary mr-auto"
                        data-dismiss="modal">@lang('common.cancel')</button>
            </div>
        @endslot
    @endcomponent
</form>