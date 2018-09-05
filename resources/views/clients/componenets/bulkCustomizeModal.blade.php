@component('bootstrap::modal',[
        'id' => 'bulkCustomizeModal'
    ])
    @slot('title')
        Customize addresses only for <b>{{ $client->name }}</b>
    @endslot
    <form id="bulkCustomizeForm"
          action="{{ route('clients.addresses.bulk', ['client' => $client, "customZone" => $selected]) }}"
          method="post">
        {{ csrf_field() }}

        <input type="hidden" name="addresses" value="">
        <div class="form-row">
            <div class="form-group col-sm-6">
                <label for="sameday_price">@lang('zone.address.sameday_price')</label>
                <input type="number" class="form-control" name="sameday_price" id="sameday_price"
                       placeholder="Keep default">
            </div>
            <div class="form-group col-sm-6">
                <label for="scheduled_price">@lang('zone.address.scheduled_price')</label>
                <input type="number" class="form-control" name="scheduled_price" id="scheduled_price"
                       placeholder="Keep default">
            </div>
        </div>
        <div class="d-flex">
            <button class="btn btn-outline-secondary"
                    data-dismiss="modal">@lang('common.cancel')</button>
            <button class="btn btn-primary ml-auto"><i
                        class="fa fa-save mr-2"></i> @lang('common.save')
            </button>
        </div>
    </form>
@endcomponent