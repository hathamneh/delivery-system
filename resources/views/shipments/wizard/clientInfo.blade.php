<fieldset>
    <legend><i class="fa fa-user-tie"></i> @lang("shipment.client_info")</legend>
    <div>
        <h2 class="step-title font-weight-bold mb-3"><i class="fa fa-user-tie"></i> @lang("shipment.client_info")</h2>
        <div class="accordion" id="shipmentClientInfo">
            <div class="card">
                <div class="card-header" id="existingClient">
                    <h5 class="mb-0">
                        <div class="custom-control custom-radio mt-2 pb-2">
                            <input type="radio" id="existingClientRadio" name="shipment_client[type]"
                                   class="custom-control-input" value="client" {{ old("shipment_client.type") == "guest" ?: "checked" }}>
                            <label class="custom-control-label" for="existingClientRadio">
                                @lang('shipment.existing_client')
                            </label>
                        </div>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="client_account_number">@lang("shipment.client_account_number")</label>
                        @component('clients.search-client-input', [
                            'name' => "shipment_client[account_number]",
                            "value" => $shipment->client->account_number ?? old('shipment_client.account_number'),
                            "placeholder" => trans('shipment.client_account_number'),
                            "disabled" => old("shipment_client.type") == "guest"
                        ]) @endcomponent
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <div class="custom-control custom-radio mt-2 pb-2">
                            <input type="radio" id="externalClientRadio" name="shipment_client[type]"
                                   class="custom-control-input" value="guest" {{ old("shipment_client.type") == "guest" ? "checked" : "" }}>
                            <label class="custom-control-label" for="externalClientRadio">
                                @lang('shipment.external_client')
                            </label>
                        </div>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="clientName">@lang('shipment.client.name') *</label>
                            <input type="text" name="shipment_client[name]" id="clientName"
                                   class="form-control" {{ old("shipment_client.type") == "guest" ?: "disabled" }} value="{{ old("shipment_client.name") }}"
                                   required placeholder="@lang('shipment.client.name')">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="clientPhone">@lang('shipment.client.phone')</label>
                            <input type="text" name="shipment_client[phone_number]" id="clientPhone"
                                   class="form-control" {{ old("shipment_client.type") == "guest" ?: "disabled" }} value="{{ old("shipment_client.phone_number") }}"
                                   placeholder="@lang('shipment.client.phone')">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="clientCountry">@lang('shipment.client.country')</label>
                            <input type="text" name="shipment_client[country]" id="clientCountry"
                                   class="form-control" {{ old("shipment_client.type") == "guest" ?: "disabled" }} value="{{ old("shipment_client.country") }}"
                                   placeholder="@lang('shipment.client.country')">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="clientCity">@lang('shipment.client.city')</label>
                            <input type="text" name="shipment_client[city]" id="clientCity"
                                   class="form-control" {{ old("shipment_client.type") == "guest" ?: "disabled" }} value="{{ old("shipment_client.city") }}"
                                   placeholder="@lang('shipment.client.city')">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</fieldset>