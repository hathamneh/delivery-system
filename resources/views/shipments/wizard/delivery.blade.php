@php /** @var \App\Shipment $shipment */ @endphp
<fieldset>
    <legend><i class="fa fa-truck"></i> @lang("shipment.delivery_details")</legend>
    <div>
        <h2 class="step-title font-weight-bold mb-3"><i class="fa fa-truck"></i> @lang("shipment.delivery_details")</h2>

        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="courier">@lang('shipment.couriers.label') *</label>
                        <select name="courier" id="courier" class="form-control selectpicker" data-live-search="true" data-bind="courier">
                            <option value="" disabled {{ old('courier') ?: "selected" }}>@lang('common.select')</option>
                            @foreach($couriers as $courier)
                                <option value="{{ $courier->id }}" {{ (old('courier') == $courier->id || (isset($shipment) && $shipment->courier->id == $courier->id)) ? "selected" : "" }}>{{ $courier->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted form-text">
                            @lang("shipment.couriers.help")
                        </small>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="internal_notes">@lang("shipment.internal_notes")</label>
                        <textarea name="internal_notes" id="internal_notes" cols="30" rows="3"
                                  placeholder="@lang("shipment.internal_notes")" data-bind="internal_notes"
                                  class="form-control">{{ isset($shipment) ? $shipment->internal_notes : old('internal_notes') }}</textarea>
                    </div>

                    <div class="w-100">
                        <hr>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="consignee_name">@lang('shipment.consignee_name') *</label>
                        <input type="text" name="consignee_name" id="consignee_name" class="form-control"
                               placeholder="@lang('shipment.consignee_name')" data-bind="consignee_name"
                               value="{{ isset($shipment) ? $shipment->consignee_name : old('consignee_name') }}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="phone_number">@lang('shipment.phone_number') *</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                               placeholder="@lang('shipment.phone_number')" required data-bind="phone_number"
                               value="{{ isset($shipment) ? $shipment->phone_number : old('phone_number') }}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="address_from_zones">@lang('shipment.address') *</label>
                        <select name="address_from_zones" id="address_from_zones" class="form-control selectpicker"
                                data-live-search="true" data-bind="address_from_zones">
                            <option value=""
                                    disabled {{ old('address_from_zones') ?: "selected" }}>@lang('common.select')</option>
                            @foreach($addresses as $address)
                                <option value="{{ $address->id }}" {{ (old('address_from_zones') == $address->id || (isset($shipment) && $shipment->address->id == $address->id)) ? "selected" : "" }}>{{ $address->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="address_maps_link">@lang('shipment.address_maps_link')</label>
                        <input type="text" name="address_maps_link" id="address_maps_link" class="form-control"
                               placeholder="@lang('shipment.address_maps_link')" data-bind="address_maps_link"
                               value="{{ isset($shipment) ? $shipment->address_maps_link : old("address_maps_link") }}">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="address_sub_text">@lang("shipment.address_sub_text")</label>
                        <textarea name="address_sub_text" id="address_sub_text" cols="30" rows="3"
                                  placeholder="@lang("shipment.address_sub_text")" data-bind="address_sub_text"
                                  class="form-control">{{ isset($shipment) ? $shipment->address_sub_text : old('address_sub_text') }}</textarea>
                    </div>

                </div>
            </div>
        </div>
        <h3 class="font-weight-bold">More</h3>
        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="service_type">@lang('shipment.service_types.label') *</label>
                        <select name="service_type" id="service_type" class="form-control selectpicker" data-bind="service_type">
                            <option value="nextday" {{ ((isset($shipment) && $shipment->service_type == "nextday") || old('service_type') == "nextday") ? "selected" : "" }}>@lang('shipment.service_types.nextday')</option>
                            <option value="sameday" {{ ((isset($shipment) && $shipment->service_type == "sameday") || old('service_type') == "sameday") ? "selected" : "" }}>@lang('shipment.service_types.sameday')</option>
                        </select>
                        <small class="form-text text-muted">
                            @lang("shipment.service_types.help")
                        </small>
                    </div>
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