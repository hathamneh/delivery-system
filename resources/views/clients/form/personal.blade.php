<div class="form-row">
    <div class="form-group col-sm-6">
        <label for="trade_name" class="control-label">@lang('client.trade_name')</label>
        <input type="text" name="trade_name" id="trade_name" required value="{{ old('trade_name') }}"
               placeholder="@lang('client.trade_name')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="name" class="control-label">@lang('client.name')</label>
        <input type="text" name="name" id="name" required value="{{ old('name') }}"
               placeholder="@lang('client.name')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="phone_number" class="control-label">@lang('client.phone')</label>
        <input type="text" name="phone_number" id="phone_number" required
               value="{{ old('phone_number') }}"
               placeholder="@lang('client.phone')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="email" class="control-label">@lang('client.email')</label>
        <input type="email" name="email" id="email" required value="{{ old('email') }}"
               placeholder="@lang('client.email')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="address_country" class="control-label">@lang('client.country')</label>
        <select class="form-control selectpicker" name="address[country]" id="address_country"
                data-live-search="true">
            <option value=""
                    disabled {{ old('address_country') ?: 'selected' }}>@lang('common.select')</option>
            @foreach($countries as $c_code => $c_name)
                <option {{ old('address.country') && old('address.country') == $c_code ? 'selected' : "" }} value="{{ $c_code }}">{{ $c_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label for="address_city" class="control-label">@lang('client.city')</label>
        <input type="text" name="address[city]" id="address_city" value="{{ old('address.city') }}"
               placeholder="@lang('client.city')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="address_sub" class="control-label">@lang('client.address_sub')</label>
        <input type="text" name="address[sub]" id="address_sub" value="{{ old('address.sub') }}"
               placeholder="@lang('client.address_sub')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="address_maps" class="control-label">@lang('client.address_maps')</label>
        <input type="text" name="address[maps]" id="address_maps" value="{{ old('address.maps') }}"
               placeholder="@lang('client.maps_placeholder')" class="form-control">
    </div>
</div>