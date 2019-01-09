@php /** @var \App\Shipment $shipment */
if(isset($shipment)) {
    $deliveryDateValue = $shipment->delivery_date->format("d-m-Y") ;
} elseif(isset($suggestedDeliveryDate)) {
    $deliveryDateValue = $suggestedDeliveryDate;
} else {
    $deliveryDateValue = old("delivery_date");
}
@endphp
<fieldset>
    <legend><i class="fa fa-info-circle"></i> @lang("shipment.details")</legend>

    <div>

        <h2 class="step-title font-weight-bold"><i class="fa fa-info-circle"></i> @lang("shipment.details")</h2>
        <p>@lang("shipment.detailsNote")</p>

        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">

                    <div class="form-group col-sm-6">
                        <label for="deliveryDate">@lang('shipment.delivery_date') *</label>
                        <input type="text" name="delivery_date" id="delivery_date" class="form-control datetimepicker"
                               required placeholder="@lang('shipment.deliveryDate')" data-bind="delivery_date"
                               value="{{ $deliveryDateValue }}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="package_weight">@lang('shipment.package_weight')</label>
                        <input type="number" name="package_weight" id="package_weight" class="form-control"
                               data-bind="package_weight" step="0.001"
                               placeholder="@lang('shipment.package_weight')" max="{{ Setting::get('max_weight') }}"
                               value="{{ isset($shipment) && !is_null($shipment) ?fnumber($shipment->package_weight,3) : (old("package_weight") ?? 0.200) }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="pieces">@lang('shipment.pieces')</label>
                        <input type="number" name="pieces" id="pieces" class="form-control"
                               data-bind="pieces"
                               placeholder="@lang('shipment.pieces')"
                               value="{{ $shipment->package_weight ?? old("pieces") ?? 1 }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="shipment_value">@lang('shipment.shipment_value')</label>
                        <input type="number" name="shipment_value" id="shipment_value" class="form-control"
                               placeholder="@lang('shipment.shipment_value')" step="0.01" min="0"
                               data-bind="shipment_value"
                               value="{{ isset($shipment) ? $shipment->shipment_value : old("shipment_value") }}">
                    </div>
                    @if(!isset($shipment))
                        <div class="form-group col-sm-6">
                            <label for="status">@lang('shipment.initial_status') *</label>
                            <select name="status" id="status" class="form-control selectpicker" data-live-search="true"
                                    data-bind="status">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status') == $status->id ? "selected" : "" }}>@lang("shipment.statuses.".$status->name)</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    {{--<div class="form-group col-sm-6">--}}
                    {{--<label for="status_more">@lang('shipment.status_more') *</label>--}}
                    {{--<select name="status_more" id="status_more" class="form-control selectpicker"--}}
                    {{--data-live-search="true">--}}
                    {{--<option value="" disabled selected>@lang('common.select')</option>--}}
                    {{--<option value="1">Status 1</option>--}}
                    {{--<option value="2">Status 2</option>--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    <div class="col-sm-6 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="custom_price" name="custom_price"
                                   value="true" {{ old('custom_price') == "true" ? "checked" : "" }}>
                            <label class="custom-control-label"
                                   for="custom_price">@lang('shipment.custom_price')</label>
                        </div>
                        <input type="number" min="0" step="0.1" placeholder="@lang('shipment.total_price')"
                               name="total_price" id="total_price"
                               value="{{ old('total_price') }}"
                               class="form-control" {{ old('custom_price') == "true" ? "" : "disabled" }}>
                        <small class="form-text text-muted">@lang('shipment.custom_price_help')</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">

                    <div class="form-group col-sm-12">
                        <label for="services" style="font-size: 1.2rem;">@lang('shipment.extra_services')</label>
                        <select name="services[]" id="services" class="form-control selectpicker" multiple
                                data-live-search="true" data-bind="extra_services"
                                data-none-selected-text="@lang("shipment.select_multi_service")">
                            @foreach($services as $service)
                                @php /** @var \App\Service $service */ @endphp
                                <option value="{{ $service->id }}"
                                        {{ (isset($shipment) && $service->hasShipment($shipment)) || (is_array(old('services')) && in_array($service->id, old('services'))) ? "selected" : "" }}
                                        data-subtext="{{ $service->price . ' ' . trans('common.jod') }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>


    </div>
</fieldset>