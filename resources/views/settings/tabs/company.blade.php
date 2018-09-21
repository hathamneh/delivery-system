<form action="{{ request()->getRequestUri() }}" method="post">
    {{ csrf_field() }}
    <div class="d-flex">
        <div class="mt-4 mx-auto">
            <p class="alert alert-info">@lang('settings.company.note')</p>
            <div class="form-group form-row">
                <label for="company.name"
                       class="col-form-label col-md-4">@lang('settings.company.name')</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="company.name" id="company.name"
                           value="{{ Setting::get("company.name") }}"
                           placeholder="@lang('settings.company.name')">
                </div>
            </div>
            <div class="form-group form-row">
                <label for="company.address"
                       class="col-form-label col-md-4">@lang('settings.company.address')</label>
                <div class="col-md-8">
                <textarea name="company.address" id="company.address" placeholder="@lang('settings.company.address')"
                          class="form-control">{{ Setting::get("company.address") }}</textarea>
                </div>
            </div>
            <div class="form-group form-row">
                <label for="company.telephone"
                       class="col-form-label col-md-4">@lang('settings.company.telephone')</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="company.telephone" id="company.telephone"
                           value="{{ Setting::get('company.telephone') }}"
                           placeholder="@lang('settings.company.telephone')">
                </div>
            </div>
            <div class="form-group form-row">
                <label for="company.pobox"
                       class="col-form-label col-md-4">@lang('settings.company.pobox')</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="company.pobox" id="company.pobox"
                           value="{{ Setting::get('company.pobox') }}"
                           placeholder="@lang('settings.company.pobox')">
                </div>
            </div>
            <div class="form-group form-row">
                <label for="company.trc" class="col-form-label col-md-4">@lang('settings.company.trc')</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="company.trc" id="company.trc"
                           value="{{ Setting::get('company.trc') }}"
                           placeholder="@lang('settings.company.trc')">
                </div>
            </div>
            <div class="form-group form-row">
                <label for="company.trc" class="col-form-label col-md-4">@lang('settings.company.trc')</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="company.trc" id="company.trc"
                           value="{{ Setting::get('company.trc') }}"
                           placeholder="@lang('settings.company.trc')">
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary" type="submit"><i class="fa-save"></i> @lang('settings.save')</button>
            </div>
        </div>
    </div>
</form>