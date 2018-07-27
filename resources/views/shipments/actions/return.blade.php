@php /** @var \App\Shipment $shipment */ @endphp

<fieldset class="shipment-actions-fieldset mt-4">
    <legend><i class="fa-reply"></i> @lang('shipment.return')</legend>
    <div>
        <p>@lang('shipment.return_notice')</p>
        <button type="button" class="btn btn-warning" data-toggle="modal"
                data-target="#returnShipment-{{ $shipment->id }}"><i
                    class="fa-reply"></i> @lang('shipment.make_returned')</button>
    </div>
</fieldset>
@component('bootstrap::modal',[
                        'id' => 'returnShipment-'.$shipment->id
                    ])
    @slot('title')
        @lang('shipment.make_returned')?
    @endslot
    <p>@lang('shipment.return_notice')</p>

    <form action="{{ route("shipments.return", ['shipment' => $shipment]) }}" method="post" class="return-form">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group">
            <label for="original_status">@lang('shipment.change_original_status')</label>
            <select name="original_status" id="original_status" class="selectpicker form-control">
                @foreach($returned_statuses as $status)
                    <option value="{{ $status->id }}" {{ $status->id == $shipment->status_id ? "selected" : "" }}>@lang('shipment.statuses.'.$status->name)</option>
                @endforeach
            </select>
        </div>
        <div class="form-group statusNotes-field">
            <label for="status_notes">@lang('shipment.status_notes')
                <small class="text-muted">(Optional)</small>
            </label>
            <textarea name="status_notes" id="status_notes" class="form-control"
                      data-target-for="statusSuggs"
                      placeholder="@lang('shipment.status_notes')">{{ $shipment->status_notes }}</textarea>
            <div class="suggestions" id="statusSuggs">
                @if(!is_null($shipment->status->suggested_reasons))
                    @foreach($shipment->status->suggested_reasons as $suggestion)
                        <a href="#" class="suggestions-item">{{ $suggestion }}</a>
                    @endforeach
                @endif
            </div>
        </div>

    </form>
    @slot('footer')
        <button class="btn btn-outline-secondary"
                data-dismiss="modal">@lang('common.cancel')</button>
        <button class="btn btn-warning ml-auto" type="button"
                data-return="{{ $shipment->id }}"><i
                    class="fa fa-reply"></i> @lang('shipment.make_returned')
        </button>
    @endslot
@endcomponent