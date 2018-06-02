<form id="createAddressForm" data-ajax="true" action="{{ route('address.store', ['zone' => $zone_id]) }}"
      method="post" data-zone-id="{{ $zone_id }}">

    <div class="form-row">
    <div class="form-group col-sm-12">
        <label for="name">@lang('zone.address.name')</label>
        <input type="text" class="form-control" name="name" id="name"
        placeholder="@lang('zone.address.name')">
    </div>
    <div class="form-group col-sm-6">
        <label for="sameday_price">@lang('zone.address.sameday_price')</label>
        <input type="text" class="form-control" name="sameday_price" id="sameday_price"
        placeholder="@lang('zone.address.sameday_price')">
    </div>
    <div class="form-group col-sm-6">
        <label for="scheduled_price">@lang('zone.address.scheduled_price')</label>
        <input type="text" class="form-control" name="scheduled_price" id="scheduled_price"
        placeholder="@lang('zone.address.scheduled_price')">
    </div>
    </div>
    <div class="d-flex">
        <button class="btn btn-outline-secondary" data-dismiss="modal">@lang('base.cancel')</button>
        <button class="btn btn-primary ml-auto"><i class="fa fa-save mr-2"></i> @lang('zone.address.new')</button>
    </div>
</form>