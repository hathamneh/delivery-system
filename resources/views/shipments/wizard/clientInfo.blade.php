<fieldset>
    <legend><i class="fa fa-user-tie"></i> @lang("shipment.client_info")</legend>
    <div>
        <h2 class="step-title font-weight-bold mb-3"><i class="fa fa-user-tie"></i> @lang("shipment.client_info")</h2>
        <div class="accordion" id="shipmentClientInfo">
            <div class="card">
                <label class="card-header" for="existingClientRadio" id="existingClient">
                    <div class="custom-control custom-radio mt-2 pb-2">
                        <h5 class="mb-0">
                            <input type="radio" id="existingClientRadio" name="shipment_client[type]"
                                   data-bind="shipment_client[type]"
                                   class="custom-control-input"
                                   value="client" {{ old("shipment_client.type") == "guest" ?: "checked" }}>
                            <span class="custom-control-label">
                                @lang('shipment.existing_client')
                            </span>
                        </h5>
                    </div>
                </label>
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
            <div class="card {{ old("shipment_client.type") == "guest" ? "" : "collapsed" }}">
                <label class="card-header" for="externalClientRadio">

                    <div class="custom-control custom-radio mt-2 pb-2">
                        <h5 class="mb-0">
                            <input type="radio" id="externalClientRadio" name="shipment_client[type]"
                                   data-bind="shipment_client[type]"
                                   class="custom-control-input"
                                   value="guest" {{ old("shipment_client.type") == "guest" ? "checked" : "" }}>

                            <span class="custom-control-label">@lang('shipment.external_client')</span>
                        </h5>
                    </div>
                </label>


                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="national_id">@lang('client.national_id') *</label>
                            <input type="text" name="shipment_client[national_id]" id="national_id"
                                   data-bind="shipment_client[national_id]" required
                                   class="form-control"
                                   {{ old("shipment_client.type") == "guest" ?: "disabled" }} value="{{ old("shipment_client.national_id") }}"
                                   placeholder="@lang('client.national_id')">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="clientName">@lang('shipment.client.name') *</label>
                            <input type="text" name="shipment_client[name]" id="clientName"
                                   data-bind="shipment_client[name]"
                                   class="form-control"
                                   {{ old("shipment_client.type") == "guest" ?: "disabled" }} value="{{ old("shipment_client.name") }}"
                                   required placeholder="@lang('shipment.client.name')">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="clientPhone">@lang('shipment.client.phone') *</label>
                            <input type="text" name="shipment_client[phone_number]" id="clientPhone"
                                   data-bind="shipment_client[phone_number]" required
                                   class="form-control"
                                   {{ old("shipment_client.type") == "guest" ?: "disabled" }} value="{{ old("shipment_client.phone_number") }}"
                                   placeholder="@lang('shipment.client.phone')">
                        </div>
                        <div class="form-group col-sm-4 col-6">
                            <label for="clientCountry">@lang('shipment.client.country')</label>
                            <input type="text" name="shipment_client[country]" id="clientCountry"
                                   data-bind="shipment_client[country]"
                                   class="form-control"
                                   {{ old("shipment_client.type") == "guest" ?: "disabled" }} value="{{ old("shipment_client.country") ?? "Jordan"  }}"
                                   placeholder="@lang('shipment.client.country')">
                        </div>
                        <div class="form-group col-sm-4 col-6">
                            <label for="clientCity">@lang('shipment.client.city')</label>
                            <input type="text" name="shipment_client[city]" id="clientCity"
                                   data-bind="shipment_client[city]"
                                   class="form-control"
                                   {{ old("shipment_client.type") == "guest" ?: "disabled" }} value="{{ old("shipment_client.city") ?? "Amman" }}"
                                   placeholder="@lang('shipment.client.city')">
                        </div>
                        <div class="form-group col-6">
                            <label for="clientAddress">@lang('client.address')</label>
                            <select name="shipment_client[address_id]" data-bind="shipment_client[address_id]"
                                    id="clientAddress" class="form-control selectpicker"
                                    data-live-search="true" disabled>
                                <option value=""
                                        disabled {{ old('shipment_client.address_id') ?: "selected" }}>@lang('common.select')</option>
                                @foreach($addresses as $address)
                                    <option value="{{ $address->id }}" data-subtext="{{ $address->zone->name }}"
                                            {{ old('shipment_client.address_id') == $address->id ? "selected" : "" }}>{{ $address->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="clientAddressDetailed">@lang('pickup.address_text')</label>
                            <input type="text" name="shipment_client[address_detailed]" id="clientAddressDetailed"
                                   data-bind="shipment_client[address_detailed]"
                                   class="form-control"
                                   {{ old("shipment_client.address_detailed") == "guest" ?: "disabled" }} value="{{ old("shipment_client.address_detailed") ?? "" }}"
                                   placeholder="@lang('pickup.address_text')">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</fieldset>