@php /** @var \App\Shipment $shipment */ @endphp
<fieldset>
    <legend><i class="fa fa-truck"></i> @lang("shipment.details")</legend>
    <div>
        <h2 class="step-title font-weight-bold mb-3"><i class="fa fa-truck"></i> @lang("shipment.details")</h2>

        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="consignee_name">@lang('shipment.consignee_name')</label>
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
                                <option value="{{ $address->id }}" data-subtext="{{ $address->zone->name }}"
                                        {{ (old('address_from_zones') == $address->id || (isset($shipment) && $shipment->address->id == $address->id)) ? "selected" : "" }}>{{ $address->name }}</option>
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
    </div>
</fieldset>