<div class="form-row">
    <div class="form-group col-sm-6">
        <label for="website_url" class="control-label">@lang('client.urls.website')</label>
        <input type="text" name="urls[website]" id="urls_website" value="{{ old('urls.website') }}"
               placeholder="@lang('client.urls.website')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="facebook_url" class="control-label">@lang('client.urls.facebook')</label>
        <input type="text" name="urls[facebook]" id="urls_facebook" value="{{ old('urls.facebook') }}"
               placeholder="@lang('client.urls.facebook')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="instagram_url" class="control-label">@lang('client.urls.instagram')</label>
        <input type="text" name="urls[instagram]" id="urls_instagram"
               value="{{ old('urls.instagram') }}"
               placeholder="@lang('client.urls.instagram')" class="form-control">
    </div>
</div>