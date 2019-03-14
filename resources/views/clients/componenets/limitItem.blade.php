@php
    /** @var \App\ClientLimit $limit */
        $checked = isset($limit) && $limit instanceOf \App\ClientLimit ? $limit->type != 'percentage' && (!is_null(old($name . '.type') && old($name . '.type') != "percentage")) : true;
@endphp

<div class="form-group">
    <label for="{{ $name }}_value" class="font-weight-bold">@lang('client.'.$name)</label>
    <input type="number" name="{{ $name }}[value]" id="{{ $name }}_value" step="any" required
           class="form-control" value="{{ old($name . '.value') ?? $limit->value ?? 0 }}">
    <small class="form-text text-muted">{!! $help !!}</small>
</div>
<div>
    <div class="form-group">
        <label>{{ $note ?? "If the limit exceeded, then on selected shipments:" }}</label>
        <div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="{{ $name }}_target-delivered" name="{{ $name }}[target][]"
                       class="custom-control-input"
                       value="delivered" {{ in_array('delivered',$limit->appliedOn ?? []) ? 'checked' : '' }}>
                <label for="{{ $name }}_target-delivered" data-toggle="tooltip"
                       title="@lang('shipment.statuses.delivered.description')"
                       class="custom-control-label">@lang('shipment.statuses.delivered.name')</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="{{ $name }}_target-cancelled" name="{{ $name }}[target][]"
                       class="custom-control-input"
                       value="cancelled" {{ in_array('cancelled',$limit->appliedOn ?? []) ? 'checked' : '' }}>
                <label for="{{ $name }}_target-cancelled" data-toggle="tooltip"
                       title="@lang('shipment.statuses.cancelled.description')"
                       class="custom-control-label">@lang('shipment.statuses.cancelled.name')</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="{{ $name }}_target-rejected" name="{{ $name }}[target][]"
                       class="custom-control-input"
                       value="rejected" {{ in_array('rejected',$limit->appliedOn ?? []) ? 'checked' : '' }}>
                <label for="{{ $name }}_target-rejected" data-toggle="tooltip"
                       title="@lang('shipment.statuses.rejected.description')"
                       class="custom-control-label">@lang('shipment.statuses.rejected.name')</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="{{ $name }}_penalty">Add this fixed value:</label>

        <div class="input-group">
            <div class="input-group-prepend btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-outline-secondary {{ $checked ? 'active' : '' }}"
                       title="@lang('client.charged_for.fixed_value')" data-toggle="tooltip">
                    <input type="radio" name="{{ $name }}[type]"
                           id="{{ $name }}_type" autocomplete="off" value="fixed" required
                            {{ $checked ? "checked" : "" }}>
                    <i class="fa-dollar-sign"></i>
                </label>
                <label class="btn btn-outline-secondary {{ !$checked ? 'active' : '' }}"
                       title="@lang('client.charged_for.percentage_value')" data-toggle="tooltip">
                    <input type="radio" name="{{ $name }}[type]"
                           id="{{ $name }}_type" autocomplete="off" value="percentage" required
                            {{ !$checked ? 'checked' : "" }}>
                    <i class="fa-percent"></i>
                </label>
            </div>
            <input class="form-control" type="number" name="{{ $name }}[penalty]"
                   id="{{ $name }}_penalty" step="any" value="{{ old($name . '.penalty') ?? $limit->penalty ?? 0 }}">
        </div>
    </div>
</div>