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
    <legend><i class="fa fa-info-circle"></i> @lang("shipment.delivery_details")</legend>

    <div>

        <h2 class="step-title font-weight-bold"><i class="fa fa-info-circle"></i> @lang("shipment.delivery_details")
        </h2>
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
                               data-bind="pieces" step="any"
                               placeholder="@lang('shipment.pieces')"
                               value="{{ $shipment->package_weight ?? old("pieces") ?? 1 }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="shipment_value">@lang('shipment.shipment_value')</label>
                        <input type="number" name="shipment_value" id="shipment_value" class="form-control"
                               placeholder="@lang('shipment.shipment_value')" step="0.01" min="0" required
                               data-bind="shipment_value"
                               value="{{ $shipment->shipment_value ?? old("shipment_value") ?? 0 }}">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="internal_notes">@lang("shipment.internal_notes")</label>
                        <textarea name="internal_notes" id="internal_notes" cols="30" rows="3"
                                  placeholder="@lang("shipment.internal_notes")" data-bind="internal_notes"
                                  class="form-control">{{ isset($shipment) ? $shipment->internal_notes : old('internal_notes') }}</textarea>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="reference">@lang('shipment.reference')</label>
                        <textarea name="reference" id="reference" class="form-control"
                                  placeholder="@lang('shipment.reference')">{{ old("reference") ?? $shipment->reference ?? "" }}</textarea>
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
                    @if(!isset($shipment))
                        <div class="form-group col-sm-6">
                            <label for="status">@lang('shipment.initial_status') *</label>
                            <select name="status" id="status" class="form-control selectpicker" data-live-search="true"
                                    data-bind="status">
                                @foreach($statuses as $status)
                                    <option data-subtext="@lang("shipment.statuses.{$status->name}.description")"
                                            value="{{ $status->id }}" {{ old('status') == $status->id ? "selected" : "" }}>@lang("shipment.statuses.{$status->name}.name")</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
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

        <h3 class="font-weight-bold">More</h3>
        <input name="service_type" id="service_type" type="hidden"
               value="{{ old('service_type') ?? $shipment->service_typ ?? 'nextday' }}">
        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="delivery_cost_lodger">@lang('shipment.delivery_cost_lodger.label') *</label>
                        <select name="delivery_cost_lodger" id="delivery_cost_lodger" class="form-control selectpicker"
                                data-bind="delivery_cost_lodger">
                            <option value="client" {{ ((isset($shipment) && $shipment->delivery_cost_lodger == "client") || old('delivery_cost_lodger') == "client")? "selected" : "" }}>@lang('shipment.delivery_cost_lodger.client')</option>
                            <option value="courier" {{ ((isset($shipment) && $shipment->delivery_cost_lodger == "courier") || old('delivery_cost_lodger') == "courier") ? "selected" : "" }}>@lang('shipment.delivery_cost_lodger.courier')</option>
                        </select>
                        <small class="form-text text-muted">
                            @lang("shipment.delivery_cost_lodger.help")
                        </small>
                    </div>

                </div>
            </div>
        </div>


    </div>
</fieldset>