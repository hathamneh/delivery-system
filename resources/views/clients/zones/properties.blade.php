<form action="{{ route('clients.zones.update', ['client'=> $client, 'zone'=> $selected]) }}"
      method="post">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-row">
        <div class="form-group col-sm-6">
            <label for="base_weight">@lang('zone.standard_weight')</label>
            <input type="text" class="form-control" name="base_weight" id="base_weight"
                   placeholder="@lang('zone.standard_weight')"
                   value="{{ old('base_weight') ?? $selected->base_weight }}">
        </div>

        <div class="form-group col-sm-6">
            <label for="charge_per_unit">@lang('zone.charge_per_unit')</label>
            <input type="text" class="form-control" name="charge_per_unit" id="charge_per_unit"
                   placeholder="@lang('zone.charge_per_unit')"
                   value="{{ old('charge_per_unit') ?? $selected->charge_per_unit }}">
        </div>
        <div class="form-group col-sm-6">
            <label for="extra_fees_per_unit">@lang('zone.extra_fees_per_unit')</label>
            <input type="text" class="form-control" name="extra_fees_per_unit"
                   id="extra_fees_per_unit"
                   value="{{ old('extra_fees_per_unit') ?? $selected->extra_fees_per_unit }}"
                   placeholder="@lang('zone.extra_fees_per_unit')">
        </div>
        <div class="form-group col-md-12">
            <button class="btn btn-primary"><i class="fa-save"></i> Save Changes</button>
        </div>
    </div>
</form>