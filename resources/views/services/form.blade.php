<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">@lang('service.name')</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="@lang('service.name')"
                value="{{ $service->name ?? old('name') ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="price">@lang('service.price')</label>
            <input type="number" step="0.1" class="form-control" name="price" id="price" placeholder="@lang('service.price')"
                   value="{{ $service->price ?? old('price') ?? '' }}" required>
        </div>
        <button class="btn btn-primary" type="submit">@lang('services.save')</button>
    </div>
</div>