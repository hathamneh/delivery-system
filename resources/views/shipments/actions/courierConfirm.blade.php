@php /** @var \App\Shipment $shipment */ @endphp

@if(auth()->user()->isCourier())
    <div class="mb-3">
        <div class="alert alert-warning">
            <b class="alert-heading">Shipments Notes</b>
            <hr>
            <p>
                {{ $shipment->internal_notes ?? "No notes" }}
            </p>
        </div>

        @if(!is_null($shipment->client->note_for_courier))
            <div class="alert alert-light">
                <b class="alert-heading">Note from client</b>
                <hr>
                <p>
                    {{ $shipment->client->note_for_courier ?? "No notes" }}
                </p>
            </div>
        @endif
        <div class="alert alert-light">
            <b class="alert-heading">@lang('shipment.reference')</b>
            <hr>
            <p>
                {{ $shipment->reference ?? "No reference" }}
            </p>
        </div>
    </div>
@endif
<div class="d-flex flex-column-reverse flex-md-row">

    <fieldset class="shipment-actions-fieldset flex-fill mr-2">
        <legend><i class="fa-shipment mr-2"></i> @lang('shipment.delivery')</legend>
        <div>

            <p>@lang('shipment.delivery_notice')</p>
            @if(!$shipment->isStatus('delivered'))
                <button type="button" class="btn btn-success mb-2" data-toggle="modal"
                        data-target="#deliveredShipment-{{ $shipment->id }}"><i
                            class="fa-check  mr-2"></i> @lang('shipment.delivered')</button>
            @endif
            <button type="button" class="btn btn-secondary mb-2" data-toggle="modal"
                    data-target="#notDeliveredShipment-{{ $shipment->id }}"><i
                        class="fa-times mr-2"></i> @lang('shipment.not_delivered')</button>
        </div>
    </fieldset>

    <div class="border rounded border-success flex-fill mx-auto py-5 mt-3 d-flex align-items-center flex-column justify-content-center w-100"
         style="max-width: 250px;">
        <div class="text-center">Current State</div>
        <div class="text-center mb-3" style="font-size: 1.3rem; font-weight: 700;" data-toggle="tooltip"
             title="@lang("shipment.statuses.{$shipment->status->name}.description")">
            @lang("shipment.statuses.{$shipment->status->name}.name")
        </div>
        <small class="text-center text-muted">
            {!! nl2br($shipment->status_notes) !!}
        </small>
    </div>
</div>
@component('bootstrap::modal',[
            'id' => 'deliveredShipment-'.$shipment->id
        ])
    @slot('title')
        Shipment delivered
    @endslot
    <form action="{{ route("shipments.delivery", ['shipment' => $shipment]) }}" method="post" class="delivered-form">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="font-weight-bold mb-3 text-info">Good job! Kindly confirm COD</div>

        @if(!($shipment instanceof \App\ReturnedShipment))
            <div class="form-group">
                <label for="actual_paid">How much did the consignee pay ?</label>
                <input type="number" step="any" name="actual_paid" id="actual_paid" class="form-control" required
                       placeholder="@lang('shipment.actual_paid')" min="{{ $shipment->cash_on_delivery }}"
                       max="{{ $shipment->cash_on_delivery }}">
            </div>
        @endif

        <div class="form-group">
            <label for="external_notes">Do you have any notes?
                <small class="text-muted">(Optional)</small>
            </label>
            <textarea name="external_notes" id="external_notes" class="form-control"
                      placeholder="Your notes"></textarea>
        </div>

        <div class="d-flex flex-row-reverse">
            <button class="btn btn-success ml-auto" type="submit" name="status" value="delivered"><i
                        class="fa fa-check mr-2"></i> @lang('shipment.make_delivered')
            </button>
            <button class="btn btn-outline-secondary" type="button"
                    data-dismiss="modal">@lang('common.cancel')</button>
        </div>
    </form>
@endcomponent

@component('bootstrap::modal',[
            'id' => 'notDeliveredShipment-'.$shipment->id
        ])
    @slot('title')
        Shipment didn't delivered
    @endslot
    <form action="{{ route("shipments.delivery", ['shipment' => $shipment]) }}" method="post"
          class="delivery-failed-form">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group delivery-reasons">
            <b class="mb-3 d-block">Why it isn't delivered?</b>
            <select name="status" id="notDeliveredStatus" class="selectpicker form-control status-changer"
                    data-target="#reasonsStep2">
                <option selected disabled>@lang('common.select')</option>
                @foreach($not_delivered_statuses as $status)
                    @php /** @var \App\Status $status */ @endphp
                    <option data-subtext="@lang("shipment.statuses.{$status->name}.description")"
                            value="{{ $status->name }}">@lang("shipment.statuses.{$status->name}.name")</option>
                @endforeach
            </select>
        </div>

        <div class="step-2" id="reasonsStep2" style="display: none;">
            <div class="message font-weight-bold mb-4 text-danger">Please provide some details</div>

            @if(!($shipment instanceof \App\ReturnedShipment))
                <div class="form-group actualPaid-input rejected">
                    <label for="actual_paid">How much did the consignee pay?</label>
                    <input type="number" step="any" name="actual_paid" id="actual_paid" class="form-control" required
                           placeholder="@lang('shipment.actual_paid')" min="0">
                </div>
            @endif

            @foreach($not_delivered_statuses as $status)
                @php /** @var \App\Status $status */ @endphp

                @if(isset($status->options['set_delivery_date']))
                    <div class="form-group deliveryDate-input {{ $status->name }}">
                        <label for="delivery_date">When the new delivery date?</label>
                        <input type="text" name="delivery_date" id="delivery_date" class="form-control datetimepicker"
                               placeholder="@lang('shipment.delivery_date')">
                    </div>
                @endif

                @if(isset($status->options['select']))
                    @foreach($status->options['select'] as $name => $choices)
                        <div class="form-group {{ $status->name }}">
                            <label for="{{ $status->name . "_" . $name }}">@lang("shipment.statuses_options.{$name}")</label>
                            <select class="selectpicker form-control" name="notes[{{ $name }}]"
                                    id="{{ $status->name . "_" . $name }}">
                                @foreach($choices as $choice)
                                    <option value="{{ $choice }}">{{ $choice }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                @endif

            @endforeach


            <div class="form-group all">
                <label for="external_notes">Do you have any notes?
                    <small class="text-muted">(Optional)</small>
                </label>
                <textarea name="external_notes" id="external_notes" class="form-control"
                          placeholder="Your notes" data-target-for="statusSuggs"></textarea>
                <div class="suggestions" id="statusSuggs">
                </div>
            </div>
        </div>

        <div class="d-flex flex-row-reverse">
            <button class="btn btn-success ml-auto" type="submit"><i
                        class="fa fa-check mr-2"></i> @lang('common.save')
            </button>
            <button class="btn btn-outline-secondary" type="button"
                    data-dismiss="modal">@lang('common.cancel')</button>
        </div>
    </form>
@endcomponent
