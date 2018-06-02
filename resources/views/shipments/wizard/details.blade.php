<fieldset>
    <legend><i class="fa fa-info-circle"></i> @lang("shipment.details")</legend>

    <div>

        <h2 class="step-title font-weight-bold"><i class="fa fa-info-circle"></i> @lang("shipment.details")</h2>
        <p>@lang("shipment.detailsNote")</p>

        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">

                    <div class="form-group col-sm-6">
                        <label for="waybill">@lang('shipment.waybill') *</label>
                        <input type="number" name="waybill" id="waybill" class="form-control" data-bind="waybill"
                               required placeholder="@lang('shipment.waybill')">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="deliveryDate">@lang('shipment.deliveryDate') *</label>
                        <input type="text" name="deliveryDate" id="deliveryDate" class="form-control datetimepicker"
                               required placeholder="@lang('shipment.deliveryDate')" data-bind="delivery_date">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="package_weight">@lang('shipment.package_weight')</label>
                        <input type="number" name="package_weight" id="package_weight" class="form-control" data-bind="package_weight"
                               placeholder="@lang('shipment.package_weight')" step="0.01" max="30">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="shipment_value">@lang('shipment.shipment_value')</label>
                        <input type="number" name="shipment_value" id="shipment_value" class="form-control"
                               placeholder="@lang('shipment.shipment_value')" step="0.01" min="0">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="status">@lang('shipment.status') *</label>
                        <select name="status" id="status" class="form-control selectpicker" data-live-search="true">
                            <option value="" disabled selected>@lang('__select__')</option>
                            @foreach(\App\Shipment::STATUS as $status_num => $status_string)
                                <option value="{{ $status_num }}">@lang("shipment.statuses.".$status_string)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="status_more">@lang('shipment.status_more') *</label>
                        <select name="status_more" id="status_more" class="form-control selectpicker"
                                data-live-search="true">
                            <option value="" disabled selected>@lang('__select__')</option>
                            <option value="1">Status 1</option>
                            <option value="2">Status 2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">

                    <div class="form-group col-sm-12">
                        <label for="services" style="font-size: 1.2rem;">@lang('shipment.extra_services') *</label>
                        <select name="services[]" id="services" class="form-control selectpicker" multiple
                                data-live-search="true"
                                data-none-selected-text="@lang("shipment.select_multi_service")">
                            <option value="1">Service 1</option>
                            <option value="2">Service 2</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>




    </div>
</fieldset>