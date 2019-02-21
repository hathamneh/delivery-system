@php /** @var \App\Shipment $shipment */ @endphp

<fieldset class="shipment-actions-fieldset mt-4">
    <legend><i class="fa-reply"></i> @lang('shipment.return')</legend>
    <div>
        @if(!($shipment instanceof \App\ReturnedShipment) && $shipment->isEditable())
            <p>@lang('shipment.return_notice')</p>
            <button type="button" class="btn btn-warning" data-toggle="modal"
                    data-target="#returnShipment-{{ $shipment->id }}"><i
                        class="fa-reply"></i> @lang('shipment.make_returned')</button>
        @else
            <div class="alert alert-light">
                <i class="fa-exclamation-triangle"></i>
                @if($shipment instanceof \App\ReturnedShipment)
                    You cannot return a returning shipment!
                @else
                    The shipment cannot be returned after it is delivered.
                @endif
            </div>
        @endif
    </div>
</fieldset>
<form action="{{ route("shipments.return", ['shipment' => $shipment]) }}" method="post" class="return-form">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    @component('bootstrap::modal',[
                            'id' => 'returnShipment-'.$shipment->id
                        ])
        @slot('title')
            @lang('shipment.make_returned')?
        @endslot
        <p>@lang('shipment.return_notice')</p>



        <div class="form-group">
            <label for="original_status">@lang('shipment.change_original_status')</label>
            <select name="original_status" id="original_status" class="selectpicker form-control status-changer"
                    data-target="#returnStep2">
                <option value="" disabled selected>@lang("common.select")</option>
                @foreach($returned_statuses as $status)
                    <option data-subtext="@lang("shipment.statuses.{$status->name}.description")"
                            value="{{ $status->name }}">@lang("shipment.statuses.{$status->name}.name")</option>
                @endforeach
            </select>
        </div>
        <div id="returnStep2" style="display: none;">
            @foreach($returned_statuses as $status)
                @if(isset($status->options['select']))
                    @foreach($status->options['select'] as $name => $choices)
                        <div class="form-group {{ $status->name }}">
                            <label for="{{ $status->name . "_" . $name }}">@lang("shipment.statuses_options.{$name}")</label>
                            <select class="selectpicker form-control"
                                    name="_notes[{{ $name }}]"
                                    id="{{ $status->name . "_" . $name }}">
                                @foreach($choices as $choice)
                                    <option value="{{ $choice }}">{{ $choice }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                @endif
            @endforeach
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
        <div class="form-group">
            <label for="deliveryDate">@lang('shipment.returnedDeliveryDate') *</label>
            <input type="text" name="delivery_date" id="delivery_date" class="form-control datetimepicker"
                   required placeholder="@lang('shipment.returnedDeliveryDate')" data-bind="delivery_date"
                   data-drp-drops="up"
                   value="{{ isset($shipment) ? $shipment->delivery_date->format("d-m-Y") : old("delivery_date") }}">
        </div>


        @slot('footer')
            <button class="btn btn-outline-secondary"
                    data-dismiss="modal">@lang('common.cancel')</button>
            <button class="btn btn-warning ml-auto" type="submit"><i
                        class="fa fa-reply"></i> @lang('shipment.make_returned')
            </button>
        @endslot
    @endcomponent
</form>