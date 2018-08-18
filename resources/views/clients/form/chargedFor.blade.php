
<div class="form-group col-sm-12">
    <div class="row">
        <div class="col-md-6">
            <fieldset class="form-fieldset fieldset-toggle">
                <legend>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="charged_rejected" name="chargedFor[rejected][enabled]"
                               class="custom-control-input" {{ old('chargedFor.rejected.enabled') == "on" ? 'checked' : "" }}>
                        <label for="charged_rejected"
                               class="custom-control-label">@lang('client.charged_for.rejected')</label>
                    </div>
                </legend>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-secondary disabled active"
                                   title="@lang('client.charged_for.fixed_value')" data-toggle="tooltip">
                                <input type="radio" name="chargedFor[rejected][type]" disabled
                                       id="charged_rejected_type" autocomplete="off" value="fixed"
                                        {{ (!old('chargedFor.rejected.type') || old('charged.rejected.type') == "fixed") ? 'checked' : "" }}>
                                <i class="fa-dollar-sign"></i>
                            </label>
                            <label class="btn btn-outline-secondary disabled"
                                   title="@lang('client.charged_for.percentage_value')" data-toggle="tooltip">
                                <input type="radio" name="chargedFor[rejected][type]" disabled
                                       id="charged_rejected_type" autocomplete="off" value="percentage"
                                        {{ (old('chargedFor.rejected.type') == "percentage") ? 'checked' : "" }}>
                                <i class="fa-percent"></i>
                            </label>
                        </div>
                        <input type="text" class="form-control" disabled
                               placeholder="@lang('client.charged_for.value')" aria-label=""
                               name="chargedFor[rejected][value]" id="charged_rejected_value"
                               value="{{ old('chargedFor.rejected.value') }}">
                    </div>

                </div>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-fieldset fieldset-toggle">
                <legend>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="charged_cancelled" name="chargedFor[cancelled][enabled]"
                               class="custom-control-input" {{ old('chargedFor.cancelled.enabled') == "on" ? 'checked' : "" }}>
                        <label for="charged_cancelled"
                               class="custom-control-label">@lang('client.charged_for.cancelled')</label>
                    </div>
                </legend>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-secondary disabled active"
                                   title="@lang('client.charged_for.fixed_value')" data-toggle="tooltip">
                                <input type="radio" name="chargedFor[cancelled][type]" disabled
                                       id="charged_cancelled_type" autocomplete="off" checked value="fixed"
                                        {{ (!old('chargedFor.cancelled.type') || old('chargedFor.cancelled.type') == "fixed") ? 'checked' : "" }}>
                                <i class="fa-dollar-sign"></i>
                            </label>
                            <label class="btn btn-outline-secondary disabled"
                                   title="@lang('client.charged_for.percentage_value')" data-toggle="tooltip">
                                <input type="radio" name="chargedFor[cancelled][type]" disabled
                                       id="charged_cancelled_type" autocomplete="off" value="percentage"
                                        {{ (old('chargedFor.cancelled.type') == "percentage") ? 'checked' : "" }}>
                                <i class="fa-percent"></i>
                            </label>
                        </div>
                        <input type="text" class="form-control" disabled
                               placeholder="@lang('client.charged_for.value')" aria-label=""
                               name="chargedFor[cancelled][value]" id="charged_cancelled_value"
                               value="{{ old('chargedFor.cancelled.value') }}">
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

</div>