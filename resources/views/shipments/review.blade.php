<fieldset>
    <legend>@lang("shipment.review")</legend>
    <div class="review-tab">
        <h2 class="step-title font-weight-bold mb-3">@lang("shipment.review")</h2>

        <div class="row">
            <div class="col-sm-6">
                <div class="card mb-2">
                    <div class="card-header">
                        <b>@lang('shipment.client_info')</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('shipment.client.type')</th>
                                <td><span data-update="shipment_client[type]"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.client_account_number')</th>
                                <td><span data-update="shipment_client[account_number]"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.client.name')</th>
                                <td><span data-update="shipment_client[name]"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.client.phone')</th>
                                <td><span data-update="shipment_client[phone_number]"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.client.country')</th>
                                <td><span data-update="shipment_client[country]"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.client.city')</th>
                                <td><span data-update="shipment_client[city]"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><b>@lang('shipment.details')</b></div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('shipment.waybill')</th>
                                <td><span data-update="waybill"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.delivery_date')</th>
                                <td><span data-update="delivery_date"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.package_weight')</th>
                                <td><span data-update="package_weight"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.pieces')</th>
                                <td><span data-update="pieces"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.shipment_value')</th>
                                <td><span data-update="shipment_value"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.initial_status')</th>
                                <td><span data-update="status"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.extra_services')</th>
                                <td><span data-update="extra_services"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header"><b>@lang('shipment.delivery_details')</b></div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('shipment.courier.label')</th>
                                <td><span data-update="courier"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.internal_notes')</th>
                                <td><span data-update="internal_notes"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.consignee_name')</th>
                                <td><span data-update="consignee_name"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.phone_number')</th>
                                <td><span data-update="phone_number"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.address')</th>
                                <td><span data-update="address_from_zones"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.address_maps_link')</th>
                                <td><span data-update="address_maps_link"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.address_sub_text')</th>
                                <td><span data-update="address_sub_text"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.service_types.label')</th>
                                <td><span data-update="service_type"></span></td>
                            </tr>
                            <tr>
                                <th>@lang('shipment.delivery_cost_lodger.label')</th>
                                <td><span data-update="delivery_cost_lodger"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>