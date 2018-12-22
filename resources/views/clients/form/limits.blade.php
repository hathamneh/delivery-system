<h3 style="font-weight: bold;">Limits</h3>
<div class="form-row">
    <div class="col-sm-6">
        <fieldset class="border p-3 rounded">
            @component('clients.componenets.limitItem', [
                'name' => "min_delivery_cost",
                'help' => "Minimum delivery cost per month.<br>Keep it 0 (zero) to disable",
                'limit' => isset($client) ? $client->limits->where('name', 'min_delivery_cost')->first(): 0,
            ]) @endcomponent
        </fieldset>
    </div>
    <div class="col-sm-6">
        <fieldset class="border p-3 rounded">
            @component('clients.componenets.limitItem', [
                'name' => "max_returned_shipments",
                'help' => "Maximum number of <b>cancelled</b> and <b>rejected</b> shipments.<br>Keep it 0 (zero) to disable",
                'limit' => isset($client) ? $client->limits->where('name', 'max_returned_shipments')->first() : 0,
            ]) @endcomponent
        </fieldset>
    </div>
</div>