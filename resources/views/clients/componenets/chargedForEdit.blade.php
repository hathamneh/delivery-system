@php /** @var App\Client $client */

/** @var \App\ClientChargedFor $cf */
$cf = isset($client) && !is_null($client) ? $client->chargedFor()->byStatus($status)->first() : null;

if(!is_null($cf)) {
    $enabled =  $client->isChargedFor($status) || old('chargedFor.'.$status.'.enabled') == "on";
    $checked = $cf->type != 'percentage' && (!is_null(old('chargedFor.'.$status.'.type') && old('charged.'.$status.'.type') != "percentage"));

} else {
    $enabled = $status === "rejected";
    $checked = !($status === "rejected");
    $defaultValue = $enabled ? "100" : "";
}

@endphp

<fieldset class="form-fieldset fieldset-toggle">
    <legend>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" id="charged_{{ $status }}" name="chargedFor[{{ $status }}][enabled]"
                   class="custom-control-input" {{ $enabled ? 'checked' : "" }}>
            <label for="charged_{{ $status }}"
                   class="custom-control-label">@lang('client.charged_for.'.$status.'')</label>
        </div>
    </legend>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-outline-secondary {{ $enabled ? '' : 'disabled' }} {{ $checked ? 'active' : '' }}"
                       title="@lang('client.charged_for.fixed_value')" data-toggle="tooltip">
                    <input type="radio" name="chargedFor[{{ $status }}][type]" {{ $enabled ? '' : 'disabled' }}
                    id="charged_{{ $status }}_type" autocomplete="off" value="fixed" required
                            {{ $checked ? "checked" : "" }}>
                    <i class="fa-dollar-sign"></i>
                </label>
                <label class="btn btn-outline-secondary {{ $enabled ? '' : 'disabled' }} {{ !$checked ? 'active' : '' }}"
                       title="@lang('client.charged_for.percentage_value')" data-toggle="tooltip">
                    <input type="radio" name="chargedFor[{{ $status }}][type]" {{ $enabled ? '' : 'disabled' }}
                    id="charged_{{ $status }}_type" autocomplete="off" value="percentage" required
                            {{ !$checked ? 'checked' : "" }}>
                    <i class="fa-percent"></i>
                </label>
            </div>
            <input type="number" step="0.01" class="form-control" {{ $enabled ? '' : 'disabled' }}
            placeholder="@lang('client.charged_for.value')" aria-label="" required
                   name="chargedFor[{{ $status }}][value]" id="charged_{{ $status }}_value"
                   value="{{  optional($cf)->value ?? old('chargedFor.'.$status.'.value') ?? $defaultValue }}">
        </div>

    </div>
</fieldset>