<h3 style="font-weight: bold;">Limits</h3>
<div class="form-row">
    <div class="form-group col-sm-6">
        <label for="min_delivery_cost">@lang('client.min_delivery_cost')</label>
        <input type="number" name="min_delivery_cost" id="min_delivery_cost" step="any"
               class="form-control" value="{{ old('min_delivery_cost') ?? $client->min_delivery_cost ?? 0 }}">
        <small class="form-text text-muted">Minimum delivery cost per month.<br>Keep it 0 (zero) to disable</small>
    </div>
    <div class="form-group col-sm-6">
        <label for="max_returned_shipments">@lang('client.max_returned_shipments')</label>
        <input type="number" name="max_returned_shipments" id="max_returned_shipments" step="1"
               class="form-control" value="{{ old('max_returned_shipments') ?? $client->max_returned_shipments ?? 0 }}">
        <small class="form-text text-muted">Maximum number of <b>cancelled</b> and <b>rejected</b> shipments.<br>Keep it 0 (zero) to disable</small>
    </div>
</div>