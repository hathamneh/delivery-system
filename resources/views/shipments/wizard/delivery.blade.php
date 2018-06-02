<fieldset>
    <legend><i class="fa fa-truck"></i> @lang("shipment.delivery_details")</legend>
    <div>
        <h2 class="step-title font-weight-bold mb-3"><i class="fa fa-truck"></i> @lang("shipment.delivery_details")</h2>

        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="courier">@lang('shipment.courier.label') *</label>
                        <select name="courier" id="courier" class="form-control selectpicker" data-live-search="true">
                            <option value="" disabled selected>@lang('__select__')</option>
                            <option value="1">courier 1</option>
                            <option value="2">courier 2</option>
                        </select>
                        <small class="text-muted form-text">
                            @lang("shipment.courier.help")
                        </small>
                    </div>

                    <div class="w-100">
                        <hr></div>
                    <div class="form-group col-sm-6">
                        <label for="consignee_name">@lang('shipment.consignee_name') *</label>
                        <input type="text" name="consignee_name" id="consignee_name" class="form-control"
                               required placeholder="@lang('shipment.consignee_name')">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="phone_number">@lang('shipment.phone_number') *</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                               placeholder="@lang('shipment.phone_number')" required>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="address_from_zones">@lang('shipment.address') *</label>
                        <select name="address_from_zones" id="address_from_zones" class="form-control selectpicker"
                                data-live-search="true">
                            <option value="" disabled selected>@lang('__select__')</option>
                            <option value="1">Amman</option>
                            <option value="2">Zarqa</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="address_maps_link">@lang('shipment.address_maps_link')</label>
                        <input type="text" name="address_maps_link" id="address_maps_link" class="form-control"
                               placeholder="@lang('shipment.address_maps_link')">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="address_sub_text">@lang("shipment.address_sub_text")</label>
                        <textarea name="address_sub_text" id="address_sub_text" cols="30" rows="3"
                                  class="form-control" placeholder="@lang("shipment.address_sub_text")"></textarea>
                    </div>

                </div>
            </div>
        </div>
        <h3 class="font-weight-bold">More</h3>
        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="service_type">@lang('shipment.service_type.label') *</label>
                        <select name="service_type" id="service_type" class="form-control selectpicker">
                            <option value="1">@lang('shipment.service_type.nextday')</option>
                            <option value="2">@lang('shipment.service_type.sameday')</option>
                        </select>
                        <small class="form-text text-muted">
                            @lang("shipment.service_type.help")
                        </small>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="delivery_cost_lodger">@lang('shipment.delivery_cost_lodger.label') *</label>
                        <select name="delivery_cost_lodger" id="delivery_cost_lodger" class="form-control selectpicker">
                            <option value="1">@lang('shipment.delivery_cost_lodger.client')</option>
                            <option value="2">@lang('shipment.delivery_cost_lodger.courier')</option>
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