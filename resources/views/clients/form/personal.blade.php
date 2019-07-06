@php /** @var App\Client $client */ @endphp

<div class="form-row">
    <div class="form-group col-sm-6">
        <label for="trade_name" class="control-label">@lang('client.trade_name') *</label>
        <input type="text" name="trade_name" id="trade_name" required value="{{ $client->trade_name ?? old('trade_name') }}"
               placeholder="@lang('client.trade_name')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="name" class="control-label">@lang('client.name') *</label>
        <input type="text" name="name" id="name" required value="{{ $client->name ?? old('name') }}"
               placeholder="@lang('client.name')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="national_id" class="control-label">@lang('client.national_id')</label>
        <input type="text" name="national_id" id="national_id" value="{{ $client->national_id ?? old('national_id') }}"
               placeholder="@lang('client.national_id')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="phone_number" class="control-label">@lang('client.phone') *</label>
        <input type="text" name="phone_number" id="phone_number" required
               value="{{ $client->phone_number ?? old('phone_number') }}"
               placeholder="@lang('client.phone')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="email" class="control-label">@lang('client.email') *</label>
        <input type="email" name="email" id="email" required value="{{ $client->email ?? old('email') }}"
               placeholder="@lang('client.email')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="address_country" class="control-label">@lang('client.country')</label>
        <select class="form-control selectpicker" name="address[country]" id="address_country"
                data-live-search="true">
            <option value=""
                    disabled {{ old('address_country') ?: 'selected' }}>@lang('common.select')</option>
            @foreach($countries as $c_code => $c_name)
                <option {{ (isset($client) && $client->address->country == $c_code) || (old('address.country') && old('address.country') == $c_code) ? 'selected' : "" }} value="{{ $c_code }}">{{ $c_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label for="address_city" class="control-label">@lang('client.city')</label>
        <input type="text" name="address[city]" id="address_city" value="{{ $client->address->city ?? old('address.city') }}"
               placeholder="@lang('client.city')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="address_sub" class="control-label">@lang('client.address_sub')</label>
        <input type="text" name="address[sub]" id="address_sub" value="{{ $client->address->sub ?? old('address.sub') }}"
               placeholder="@lang('client.address_sub')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="address_maps" class="control-label">@lang('client.address_maps')</label>
        <input type="text" name="address[maps]" id="address_maps" value="{{ $client->address->maps ?? old('address.maps') }}"
               placeholder="@lang('client.maps_placeholder')" class="form-control">
    </div>
</div>
<hr>
<div class="form-row">
    <div class="form-group col-sm-6">
        <label for="sector" class="control-label">@lang('client.sector')</label>
        <input type="text" name="sector" id="sector" value="{{ $client->sector ?? old('sector') }}"
               placeholder="@lang('client.sector')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="category" class="control-label">@lang('client.category') *</label>
        <select name="category" id="category" required class="selectpicker form-control">
            <option {{ (isset($client) && $client->category == 1) || (old('category') && old('category') == 1) ? 'selected' : '' }} value="1">@lang('client.online_store')</option>
            <option {{ (isset($client) && $client->category == 2) || (old('category') && old('category') == 2) ? 'selected' : '' }} value="2">@lang('client.local_store')</option>
        </select>
    </div>
</div>