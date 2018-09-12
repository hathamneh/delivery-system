@php
    $action = isset($address) ? route('address.update', ['zone'=>$zone->id, 'address'=>$address->id]) : route('address.store', ['zone' => $zone->id])
@endphp
<form id="createAddressForm" data-ajax="{{ (isset($ajax) && $ajax) ? "true" : "false" }}"
      action="{{ $action }}"
      method="post" data-zone-id="{{ $zone->id }}">

    @if(isset($address))
        {{ method_field('PUT') }}
    @endif
    @if(!isset($ajax) || !$ajax)
        {{ csrf_field() }}
    @endif

    <div class="form-row">
        <div class="form-group col-sm-12">
            <label for="name">@lang('zone.address.name')</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $address->name ?? "" }}"
                   placeholder="@lang('zone.address.name')">
        </div>
        <div class="form-group col-sm-6">
            <label for="sameday_price">@lang('zone.address.sameday_price')</label>
            <input type="text" class="form-control" name="sameday_price" id="sameday_price"
                   value="{{ $address->sameday_price ?? "" }}"
                   placeholder="@lang('zone.address.sameday_price')">
        </div>
        <div class="form-group col-sm-6">
            <label for="scheduled_price">@lang('zone.address.scheduled_price')</label>
            <input type="text" class="form-control" name="scheduled_price" id="scheduled_price"
                   value="{{ $address->scheduled_price ?? "" }}"
                   placeholder="@lang('zone.address.scheduled_price')">
        </div>
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary ml-auto"><i
                    class="fa fa-save mr-2"></i> {{ isset($address) ? trans('zone.address.save') : trans('zone.address.new') }}
        </button>
        <button class="btn btn-outline-secondary" data-dismiss="modal">@lang('common.cancel')</button>
    </div>
</form>