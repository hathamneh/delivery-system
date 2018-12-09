<form action="{{ request()->getRequestUri() }}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="mt-4 col-md-8 mx-auto">
            <div class="form-group form-row">
                <label for="company.name"
                       class="col-form-label col-md-4">@lang('settings.accounting.freelanceShare')</label>
                <div class="col-md-8">
                    <input type="number" class="form-control" name="accounting.freelanceShare" id="accounting.freelanceShare"
                           value="{{ Setting::get("accounting.freelanceShare") }}"
                           placeholder="@lang('settings.accounting.freelanceShare')">
                </div>
            </div>
            <div class="form-group form-row">
                <label for="company.address"
                       class="col-form-label col-md-4">@lang('settings.accounting.promoRequirement')</label>
                <div class="col-md-8">
                <input name="accounting.promoRequirement" id="accounting.promoRequirement" placeholder="@lang('settings.accounting.promoRequirement')"
                          class="form-control" value="{{ Setting::get("accounting.promoRequirement") }}" type="number">
                </div>
            </div>
            <div class="form-group form-row">
                <label for="company.telephone"
                       class="col-form-label col-md-4">@lang('settings.accounting.promoValue')</label>
                <div class="col-md-8">
                    <input type="number" class="form-control" name="accounting.promoValue" id="accounting.promoValue"
                           value="{{ Setting::get('accounting.promoValue') }}" step="0.1"
                           placeholder="@lang('settings.accounting.promoValue')">
                </div>
            </div>
            <div class="form-group form-row">
                <label for="company.pobox"
                       class="col-form-label col-md-4">@lang('settings.accounting.maxWeight')</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="accounting.maxWeight" id="accounting.maxWeight"
                           value="{{ Setting::get('accounting.maxWeight') }}" step="0.1"
                           placeholder="@lang('settings.accounting.maxWeight')">
                </div>
            </div>
            <div class="form-group form-row">
                <label for="company.trc" class="col-form-label col-md-4">@lang('settings.accounting.loyaltyDays')</label>
                <div class="col-md-8">
                    <input type="number" class="form-control" name="accounting.loyaltyDays" id="accounting.loyaltyDays"
                           value="{{ Setting::get('accounting.loyaltyDays') }}"
                           placeholder="@lang('settings.accounting.loyaltyDays')">
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary" type="submit"><i class="fa-save"></i> @lang('settings.save')</button>
            </div>
        </div>
    </div>
</form>