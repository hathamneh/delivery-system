@component('bootstrap::modal',[
        'id' => 'addCustomAddressModal'
    ])
    @slot('title')
        Customize addresses only for <b>{{ $client->name }}</b>
    @endslot
    <form id="addCustomAddressForm"
          action="{{ route('clients.addresses.store', ['client' => $client, "customZone" => $selected]) }}"
          method="post">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-sm-12">
                <label for="name">@lang('zone.address.name')</label>
                <input type="text" class="form-control" name="name" id="name" required
                       placeholder="@lang('zone.address.name')">
            </div>
            <div class="form-group col-sm-6">
                <label for="sameday_price">@lang('zone.address.sameday_price')</label>
                <input type="number" class="form-control" name="sameday_price" id="sameday_price" required
                       placeholder="@lang('zone.address.sameday_price')">
            </div>
            <div class="form-group col-sm-6">
                <label for="scheduled_price">@lang('zone.address.scheduled_price')</label>
                <input type="number" class="form-control" name="scheduled_price" id="scheduled_price" required
                       placeholder="@lang('zone.address.scheduled_price')">
            </div>
        </div>
        <div class="d-flex flex-row-reverse">
            <button class="btn btn-primary ml-auto" type="submit"><i
                        class="fa fa-save mr-2"></i> @lang('common.save')
            </button>
            <button class="btn btn-outline-secondary" type="button"
                    data-dismiss="modal">@lang('common.cancel')</button>
        </div>
    </form>
@endcomponent