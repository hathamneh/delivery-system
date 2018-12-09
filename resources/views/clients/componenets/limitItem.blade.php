<div class="form-group">
    <label for="{{ $name }}_value" class="font-weight-bold">@lang('client.'.$name)</label>
    <input type="number" name="{{ $name }}[value]" id="{{ $name }}_value" step="any"
           class="form-control" value="{{ old($name . '.value') ?? $limit->value ?? 0 }}">
    <small class="form-text text-muted">{!! $help !!}</small>
</div>
<div>
    <div class="form-group">
        <label>If the limit exceeded, then on selected shipments:</label>
        <div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="{{ $name }}_target-delivered" name="{{ $name }}[target][]"
                       class="custom-control-input" value="delivered" {{ in_array('delivered',$limit->appliedOn ?? []) ? 'checked' : '' }}>
                <label for="{{ $name }}_target-delivered"
                       class="custom-control-label">@lang('shipment.statuses.delivered')</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="{{ $name }}_target-cancelled" name="{{ $name }}[target][]"
                       class="custom-control-input" value="cancelled" {{ in_array('cancelled',$limit->appliedOn ?? []) ? 'checked' : '' }}>
                <label for="{{ $name }}_target-cancelled"
                       class="custom-control-label">@lang('shipment.statuses.cancelled')</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="{{ $name }}_target-rejected" name="{{ $name }}[target][]"
                       class="custom-control-input" value="rejected" {{ in_array('rejected',$limit->appliedOn ?? []) ? 'checked' : '' }}>
                <label for="{{ $name }}_target-rejected"
                       class="custom-control-label">@lang('shipment.statuses.rejected')</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="{{ $name }}_penalty">Add this fixed value:</label>
        <input class="form-control" type="number" name="{{ $name }}[penalty]"
               id="{{ $name }}_penalty" step="any" value="{{ old($name . '.penalty') ?? $limit->penalty ?? 0 }}">
    </div>
</div>