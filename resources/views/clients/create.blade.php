@extends('layouts.clients')


@section('breadcrumbs')
    {{ Breadcrumbs::render('clients.create') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("client.create")
@endsection

@section('content')
    <form action="{{ route('clients.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            @if ($errors->any())
                <div class="col-md-8">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="col-md-8 mx-auto">

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
                        <input type="text" name="phone_number" id="phone_number" required value="{{ old('phone_number') }}"
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
                            <option value="" disabled {{ old('address_country') ?: 'selected' }}>@lang('common.select')</option>
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
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="zone_id" class="control-label">@lang('client.zone')</label>
                        <select name="zone_id" id="zone_id" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" disabled {{ old('zone_id') ?: 'selected' }}>@lang('common.select')</option>
                            @foreach($zones as $zone)
                                <option {{ old('zone_id') && old('zone_id') == $c_code ? 'selected' : "" }} value="{{ $zone->id }}">{{ $zone->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="pickup_address_text"
                               class="control-label">@lang('client.pickup_address_text')</label>
                        <input type="text" name="pickup_address[text]" id="pickup_address_text" value="{{ old('pickup_address.text') }}"
                               placeholder="@lang('client.pickup_address_text')" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="pickup_address_maps"
                               class="control-label">@lang('client.pickup_address_maps')</label>
                        <input type="text" name="pickup_address[maps]" id="pickup_address_maps" value="{{ old('pickup_address.maps') }}"
                               placeholder="@lang('client.maps_placeholder')" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="sector" class="control-label">@lang('client.sector')</label>
                        <input type="text" name="sector" id="sector" value="{{ old('sector') }}"
                               placeholder="@lang('client.sector')" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="category" class="control-label">@lang('client.category')</label>
                        <select name="category" id="category" required class="selectpicker form-control">
                            <option {{ old('category') && old('category') == 1 ? 'selected' : 0 }} value="1">@lang('client.online_store')</option>
                            <option {{ old('category') && old('category') == 2 ? 'selected' : 0 }} value="2">@lang('client.local_store')</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-sm-12">
                        <label for="bank_name" class="control-label">@lang('client.bank.info')</label>
                    </div>
                    <div class="form-group col-sm-6">
                        <input type="text" name="bank[name]" id="bank_name" value="{{ old('bank.name') }}"
                               placeholder="@lang('client.bank.name')" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <input type="text" name="bank[account_number]" id="bank_account_number" value="{{ old('bank.account_number') }}"
                               placeholder="@lang('client.bank.account_number')" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <input type="text" name="bank[holder_name]" id="bank_holder_name" value="{{ old('bank.holder_name') }}"
                               placeholder="@lang('client.bank.holder_name')" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <input type="text" name="bank[iban]" id="bank_iban" value="{{ old('bank.iban') }}"
                               placeholder="@lang('client.bank.iban')" class="form-control">
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
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
                        <input type="text" name="urls[instagram]" id="urls_instagram" value="{{ old('urls.instagram') }}"
                               placeholder="@lang('client.urls.instagram')" class="form-control">
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="control-label">@lang('client.files')</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" multiple name="client_files[]" id="client_files">
                            <label class="custom-file-label" for="client_files">Choose file</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="custom-sticky-top">
                    <div class="extra-form-info">
                        <label for="account_number"
                               class="control-label font-weight-light">@lang('client.c_account_number')</label>
                        <div class="form-readonly">{{ $next_account_number ?? "" }}</div>
                    </div>
                    <div class="form-side-actions">
                        <button class="btn btn-outline-secondary"><i class="fa-times"></i> @lang('common.cancel')
                        </button>
                        <button class="btn btn-primary"><i class="fa-save"></i> @lang('client.save')</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection