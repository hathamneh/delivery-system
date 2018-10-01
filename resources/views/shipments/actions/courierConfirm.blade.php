@php /** @var \App\Shipment $shipment */ @endphp

<div class="alert alert-warning">
    <b class="alert-heading">Shipments Notes</b>
    <hr>
    <p>
        {{ $shipment->internal_notes ?? "No notes" }}
    </p>
</div>
<div class="alert alert-light">
    <b class="alert-heading">@lang('shipment.reference')</b>
    <hr>
    <p>
        {{ $shipment->reference ?? "No reference" }}
    </p>
</div>
<div class="d-flex mt-4 flex-column-reverse flex-md-row">

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

    <div class="border rounded border-success flex-fill mx-auto py-5 mb-3 d-flex align-items-center flex-column justify-content-center w-100"
         style="max-width: 250px;">
        <div class="text-center">Current State</div>
        <div class="text-center" style="font-size: 1.3rem; font-weight: 700;">
            @lang('shipment.statuses.'.$shipment->status->name)
        </div>
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

        <div class="form-group">
            <label for="actual_paid">How much did the consignee pay ?</label>
            <input type="number" step="any" name="actual_paid" id="actual_paid" class="form-control" required
                   placeholder="@lang('shipment.actual_paid')" min="0" max="{{ $shipment->cash_on_delivery }}">
        </div>

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
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="rejected" name="status" value="rejected" required data-status-suggest
                       class="custom-control-input" data-message="We're sorry for that, Please provide some details">
                <label class="custom-control-label" for="rejected">Rejected</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="not_available" name="status" value="not_available" required
                       class="custom-control-input" data-status-suggest
                       data-message="We're sorry for wasting your time, Kindly provide some details">
                <label class="custom-control-label" for="not_available">Not Available</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="cancelled" name="status" value="cancelled" required
                       class="custom-control-input" data-status-suggest
                       data-message="We're sorry for wasting your time, Kindly provide some details">
                <label class="custom-control-label" for="cancelled">Cancelled</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="failed" name="status" value="failed" required
                       class="custom-control-input" data-status-suggest
                       data-message="We're sorry for wasting your time, Kindly provide some details">
                <label class="custom-control-label" for="failed">Failed</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="consignee_rescheduled" name="status" value="consignee_rescheduled" required
                       class="custom-control-input" data-status-suggest
                       data-message="Kindly inform us about the requested time and any additional details">
                <label class="custom-control-label" for="consignee_rescheduled">Consignee Rescheduled</label>
            </div>
        </div>

        <div class="step-2" style="display: none;">
            <div class="message font-weight-bold mb-4 text-danger"></div>

            <div class="form-group actualPaid-input">
                <label for="actual_paid">How much did the consignee pay?</label>
                <input type="number" step="any" name="actual_paid" id="actual_paid" class="form-control" required
                       placeholder="@lang('shipment.actual_paid')" min="0" max="{{ $shipment->cash_on_delivery }}">
            </div>

            <div class="form-group deliveryDate-input" style="display: none;">
                <label for="delivery_date">When the new delivery date?</label>
                <input type="text" name="delivery_date" id="delivery_date" class="form-control datetimepicker"
                       placeholder="@lang('shipment.delivery_date')">
            </div>

            <div class="form-group">
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
