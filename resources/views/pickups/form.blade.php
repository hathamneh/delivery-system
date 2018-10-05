@php /** @var \App\Pickup $pickup */ @endphp

<div class="form-row">

    <div class="form-group col-sm-12">
        <label for="client_account_number">@lang('pickup.client_account_number')</label>
        @component('clients.search-client-input', [
            'name' => "client_account_number",
            'value' => $pickup->client->account_number ?? old('client_account_number'),
            'placeholder' => trans('pickup.client_account_number'),
            'disabled' => isset($pickup) ? true : false
        ]) @endcomponent
    </div>

    <div class="col-sm-12 form-group">
        <label for="waybills">@lang('pickup.waybills')</label>
        <div>
            <select name="waybills[]" id="waybills" class="select2-waybills form-control"
                    multiple="multiple" data-tags="true" data-placeholder="@lang('pickup.waybills')">
                @if(isset($pickup) && $pickup->shipments->count()))
                @foreach($pickup->shipments as $shipment)
                    <?php /** @var \App\Shipment $shipment */ ?>
                    <option value="{{ $shipment->waybill }}" selected>{{ $shipment->waybill }}</option>
                @endforeach
                @elseif(old('waybills'))
                    @foreach(old('waybills') as $waybill)
                        <option value="{{ $waybill }}" selected>{{ $waybill }}</option>
                    @endforeach
                @else
                    <option value=""></option>
                @endif
            </select>
        </div>
    </div>

    <div class="form-group col-sm-6">
        <label for="available_time">@lang('pickup.available_time')</label>
        <input type="text" name="available_day" id="available_day"
               value="{{ isset($pickup) ? $pickup->available_day : old('available_time') }}"
               class="form-control datetimepicker">
    </div>
    <div class="form-group col-sm-3 col-6">
        <label for="available_time">From:</label>
        <input type="text" name="time_start" id="time_start"
               value="{{ isset($pickup) ? $pickup->time_start : old('available_time') }}"
               class="form-control timepicker">
    </div>
    <div class="form-group col-sm-3 col-6">
        <label for="available_time">To:</label>
        <input type="text" name="time_end" id="time_end"
               value="{{ isset($pickup) ? $pickup->time_end : old('available_time') }}"
               class="form-control timepicker">
    </div>

    <div class="col-sm-12">
        <hr>
    </div>

    <div class="form-group col-sm-12">
        <label for="courier_id">@lang('pickup.courier')</label>
        <select name="courier_id" id="courier_id" class="form-control selectpicker" data-live-search="true" required>
            <option value="" disabled {{ old('courier') ?: "selected" }}>@lang('common.select')</option>
            @foreach($couriers as $courier)
                <option data-subtext="{{ $courier->zone->name }}"
                        value="{{ $courier->id }}" {{ (old('courier') == $courier->id || (isset($pickup) && $pickup->courier->id == $courier->id)) ? "selected" : "" }}>{{ $courier->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-sm-6">
        <label for="expected_packages_number">@lang('pickup.expected_packages_number')</label>
        <input type="number" class="form-control" name="expected_packages_number"
               id="expected_packages_number" placeholder="@lang('pickup.expected_packages_number')"
               required value="{{ $pickup->expected_packages_number ?? old('expected_packages_number') }}">
    </div>

    <div class="form-group col-sm-6">
        <label for="pickup_fees">@lang('pickup.pickup_fees')</label>
        <input type="number" class="form-control" name="pickup_fees" step="0.1"
               id="pickup_fees" placeholder="@lang('pickup.pickup_fees')"
               value="{{ $pickup->pickup_fees ?? old('pickup_fees') }}">
    </div>


    <div class="col-sm-12 form-group">
        <div class="card card-transparent">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <b>@lang('pickup.pickup_from')</b>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline mt-2 pb-2">
                                <input type="radio" id="pickup_from_client" name="pickup_from"
                                       class="custom-control-input"
                                       value="client" {{ (isset($pickup) && $pickup->pickup_from == 'customer') || old('pickup_from') == 'customer' ? "" : "checked" }}>
                                <label class="custom-control-label" for="pickup_from_client">
                                    @lang('pickup.from_client')
                                    <br>
                                    <small class="text-muted">@lang('pickup.from_client_description')</small>
                                </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline mt-2 pt-2 mb-2 mb-sm-0">
                                <input type="radio" id="pickup_from_customer" name="pickup_from"
                                       class="custom-control-input"
                                       value="customer" {{ (isset($pickup) && $pickup->pickup_from == 'customer') || old('pickup_from') == 'customer' ? "checked" : "" }}>
                                <label class="custom-control-label" for="pickup_from_customer">
                                    @lang('pickup.from_customer')
                                    <br>
                                    <small class="text-muted">@lang('pickup.from_customer_description')</small>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <div class="form-row">
                            <div class="col-sm-6 form-group">
                                <label for="client_name">@lang('pickup.client_name')</label>
                                <input type="text" name="client_name" id="client_name" required
                                       class="form-control"
                                       value="{{ $pickup->client_name ?? old('client_name') }}"
                                       placeholder="@lang('pickup.client_name')">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="national_id">@lang('client.national_id')</label>
                                <input type="text" name="national_id" id="national_id" required
                                       class="form-control"
                                       value="{{ $pickup->national_id ?? old('national_id') }}"
                                       placeholder="@lang('client.national_id')">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="phone_number">@lang('pickup.phone')</label>
                                <input type="text" name="phone_number" id="phone_number" required
                                       class="form-control"
                                       value="{{ $pickup->phone_number ?? old('phone_number') }}"
                                       placeholder="@lang('pickup.phone')">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="pickup_address_text">@lang('pickup.address_text')</label>
                                <input type="text" name="pickup_address.text" id="pickup_address_text"
                                       class="form-control" title="@lang('pickup.address_text')" data-toggle="tooltip"
                                       value="{{ $pickup->pickup_address_text ?? old('pickup_address.text') }}"
                                       data-placement="left"
                                       placeholder="@lang('pickup.address_text')">
                            </div>
                            <div class="col-sm-4">
                                <label for="pickup_address_maps">@lang('pickup.address_maps')</label>
                                <input type="text" name="pickup_address.maps" id="pickup_address_maps"
                                       class="form-control" title="@lang('pickup.address_maps')" data-toggle="tooltip"
                                       value="{{ $pickup->pickup_address_maps ?? old('pickup_address.maps') }}"
                                       data-placement="left"
                                       placeholder="@lang('pickup.address_maps')">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 form-group">
        <label for="notes_internal">@lang('pickup.notes')</label>
        <textarea name="notes_internal" id="notes_internal" class="form-control"
                  placeholder="@lang('pickup.notes')">{{ $pickup->notes_internal ?? old('notes.internal') }}</textarea>
    </div>

    <div class="col-sm-12">
        <hr>
        <div class="d-flex">
            <a href="{{ route('pickups.index') }}" class="btn btn-secondary">@lang('common.cancel')</a>
            <button type="submit" class="btn btn-primary ml-auto"><i
                        class="fa-save"></i> @lang('pickup.save')</button>
        </div>
    </div>
</div>