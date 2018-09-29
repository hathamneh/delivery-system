@php /** @var \App\Shipment $shipment */ @endphp
<form action="{{ route('shipments.update', ['shipment' => $shipment,'tab' => "status"]) }}" method="post">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <fieldset class="shipment-actions-fieldset">
        <legend>@lang("shipment.change_status")</legend>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="status">@lang('shipment.status')</label>
                <select name="status" id="status" class="selectpicker form-control">
                    @foreach($statuses as $status)
                        @if($status->name != "returned")
                            <option value="{{ $status->id }}" {{ $shipment->status_id == $status->id ? "selected" : "" }}>@lang('shipment.statuses.'.$status->name)</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group newDeliveryDate-input col-md-6" style="display: none;">
                <label for="delivery_date">When the new delivery date?</label>
                <input type="text" name="delivery_date" id="delivery_date" class="form-control datetimepicker"
                       placeholder="@lang('shipment.delivery_date')">
            </div>
            <div class="form-group col-md-12 statusNotes-field">
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
        </div>
        <div class="">
            <button class="btn btn-primary" type="submit">@lang('shipment.change_status')</button>
        </div>
    </fieldset>
</form>