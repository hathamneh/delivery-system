<fieldset>
    <legend>@lang("shipment.review")</legend>
    <div>
        <h2 class="step-title font-weight-bold mb-3">@lang("shipment.review")</h2>

        <div class="row">
            <div class="col-sm-6">
                <div class="card mb-2">
                    <div class="card-body">
                        <div>@lang('shipment.client_account_number') <span
                                    data-update="client_account_number"></span></div>
                        <div>@lang('shipment.client.name') <span data-update="client_name"></span></div>
                        <div>@lang('shipment.client.name') <span data-update="client_name"></span></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>@lang('shipment.waybill') <span data-update="waybill"></span></div>
                        <div>@lang('shipment.delivery_date') <span data-update="delivery_date"></span></div>
                        <div>@lang('shipment.package_weight') <span data-update="package_weight"></span></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        Delivery
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>