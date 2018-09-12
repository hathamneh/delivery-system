@component('bootstrap::modal',[
                        'id' => ($custom == true ? 'editCustomAddress-' : 'customizeAddress-') . $address->id
                    ])
    @slot('title')
        Customize <b>{{ $address->name }}</b> only for <b>{{ $client->name }}</b>
    @endslot
    <form id="customizeAddressForm-{{ $address->id }}"
          action="{{ route($route, ['client' => $client, 'address' => $address, "customZone" => $selected]) }}"
          method="post">
        @if($custom)
            {{ method_field("PUT") }}
        @endif
        {{ csrf_field() }}

        <div class="form-row">
            <div class="form-group col-sm-6">
                <label for="sameday_price">@lang('zone.address.sameday_price')</label>
                <input type="number" step="0.01" class="form-control" name="sameday_price" id="sameday_price"
                       value="{{ $address->sameday_price ?? "" }}"
                       placeholder="@lang('zone.address.sameday_price')">
            </div>
            <div class="form-group col-sm-6">
                <label for="scheduled_price">@lang('zone.address.scheduled_price')</label>
                <input type="number" step="0.01" class="form-control" name="scheduled_price" id="scheduled_price"
                       value="{{ $address->scheduled_price ?? "" }}"
                       placeholder="@lang('zone.address.scheduled_price')">
            </div>
        </div>
        <div class="d-flex flex-row-reverse">
            <button class="btn btn-primary"><i
                        class="fa fa-save mr-2"></i> {{ isset($address) ? trans('zone.address.save') : trans('zone.address.new') }}
            </button>
            <button class="btn btn-outline-secondary mr-auto"
                    data-dismiss="modal">@lang('common.cancel')</button>
        </div>
    </form>
@endcomponent