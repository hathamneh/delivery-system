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
            <div class="form-group col-sm-12">
                <label for="name" class="control-label">@lang('courier.name') *</label>
                <input type="text" name="name" id="name" required value="{{ old('name') ?? $courier->name ?? "" }}"
                       placeholder="@lang('courier.name')" class="form-control">
            </div>
            <div class="form-group col-sm-6">
                <label for="phone_number" class="control-label">@lang('courier.phone')</label>
                <input type="text" name="phone_number" id="phone_number"
                       value="{{ old('phone_number') ?? $courier->phone_number ?? "" }}"
                       placeholder="@lang('courier.phone')" class="form-control">
            </div>
            <div class="form-group col-sm-6">
                <label for="email" class="control-label">@lang('courier.email')</label>
                <input type="email" name="email" id="email" value="{{ old('email') ?? $courier->email ?? "" }}"
                       placeholder="@lang('courier.email')" class="form-control">
            </div>
            <div class="form-group col-sm-6">
                <label for="zone_id" class="control-label">@lang('courier.zone') *</label>
                <select name="zone_id" id="zone_id" class="form-control selectpicker" data-live-search="true" required>
                    <option value="" disabled {{ old('zone_id') ?: 'selected' }}>@lang('common.select')</option>
                    @foreach($zones as $zone)
                        <option {{ (old('zone_id') && old('zone_id') == $zone->id) || (isset($courier) && $courier->zone_id == $zone->id) ? 'selected' : "" }}
                                value="{{ $zone->id }}">{{ $zone->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label for="address"
                       class="control-label">@lang('courier.address')</label>
                <input type="text" name="address" id="address" value="{{ old('address') ?? $courier->address ?? "" }}"
                       placeholder="@lang('courier.address')" class="form-control">
            </div>
            <div class="form-group col-sm-6">
                <label for="category" class="control-label">@lang('courier.category') *</label>
                <select name="category" id="category" class="form-control selectpicker" data-live-search="true"
                        required>
                    <option value="" disabled {{ old('category') ?: 'selected' }}>@lang('common.select')</option>
                    <option {{ (old('category') && old('category') == 1) || (isset($courier) && $courier->category == 1) ? 'selected' : "" }}
                            value="1">@lang('courier.employee')</option>
                    <option {{ (old('category') && old('category') == 2) || (isset($courier) && $courier->category == 2) ? 'selected' : "" }}
                            value="2">@lang('courier.freelance')</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="form-group col-sm-12">
                <label class="control-label">@lang('courier.files')</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" multiple name="courier_files[]" id="courier_files">
                    <label class="custom-file-label" for="courier_files">Choose file</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="form-group col-sm-12">
                <label for="notes" class="control-label">@lang('courier.notes')</label>
                <textarea name="notes" id="notes" cols="30" class="form-control"
                          placeholder="@lang('courier.notes')">{{ old('notes') ?? $courier->notes ?? "" }}</textarea>
            </div>
        </div>
        <hr>
    </div>
    <div class="col-md-8 mx-auto">
        <div class="d-flex">
            <a class="btn btn-outline-secondary" href="{{ route('couriers.index') }}"><i
                        class="fa-times"></i> @lang('common.cancel')
            </a>
            <button class="btn btn-primary ml-auto"><i class="fa-save"></i> @lang('courier.save')</button>
        </div>
    </div>
</div>