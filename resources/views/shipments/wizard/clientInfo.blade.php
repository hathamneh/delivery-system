<fieldset>
    <legend><i class="fa fa-user"></i> @lang("shipment.client_info")</legend>
    <div>
        <h2 class="step-title font-weight-bold mb-3"><i class="fa fa-user"></i> @lang("shipment.client_info")</h2>
            <div class="accordion" id="shipmentClientInfo">
                <div class="card">
                    <div class="card-header" id="existingClient">
                        <h5 class="mb-0">
                            <label for="existingClientRadio">
                                <input type="radio" name="shipment_client_type" id="existingClientRadio" checked>
                                @lang('shipment.existing_client')
                            </label>

                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="client_account_number">@lang("shipment.client_account_number")</label>
                            <input class="form-control" id="client_account_number"
                                   name="client_account_number" data-bind="client_account_number"
                                   placeholder="@lang('shipment.client_placeholder')">
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <label for="externalClientRadio">
                                <input type="radio" name="shipment_client_type" id="externalClientRadio">
                                @lang('shipment.external_client')
                            </label>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label for="clientName">@lang('shipment.client.name') *</label>
                                <input type="text" name="clientName" id="clientName"
                                       class="form-control" disabled
                                       required placeholder="@lang('shipment.client.name')">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="clientPhone">@lang('shipment.client.phone')</label>
                                <input type="text" name="clientPhone" id="clientPhone"
                                       class="form-control" disabled
                                       placeholder="@lang('shipment.client.phone')">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="clientCountry">@lang('shipment.client.country')</label>
                                <input type="text" name="clientCountry" id="clientCountry"
                                       class="form-control" disabled
                                       placeholder="@lang('shipment.client.country')">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="clientCity">@lang('shipment.client.city')</label>
                                <input type="text" name="clientCity" id="clientCity"
                                       class="form-control" disabled
                                       placeholder="@lang('shipment.client.city')">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>
</fieldset>