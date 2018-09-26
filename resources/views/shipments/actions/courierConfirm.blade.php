@php /** @var \App\Shipment $shipment */ @endphp

<div class="alert alert-warning">
    <b class="alert-heading">Shipments Notes</b>
    <hr>
    <p>
        {{ $shipment->internal_notes }}
    </p>
</div>

<fieldset class="shipment-actions-fieldset mt-4">
    <legend><i class="fa-shipment mr-2"></i> @lang('shipment.delivery')</legend>
    <div>
        <p>@lang('shipment.delivery_notice')</p>
        <button type="button" class="btn btn-success" data-toggle="modal"
                data-target="#deliveredShipment-{{ $shipment->id }}"><i
                    class="fa-check  mr-2"></i> @lang('shipment.delivered')</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal"
                data-target="#notDeliveredShipment-{{ $shipment->id }}"><i
                    class="fa-times mr-2"></i> @lang('shipment.not_delivered')</button>
    </div>
</fieldset>
@component('bootstrap::modal',[
            'id' => 'deliveredShipment-'.$shipment->id
        ])
    @slot('title')
        Good job
    @endslot
    <form action="{{ route("shipments.delivery", ['shipment' => $shipment]) }}" method="post" class="delivered-form">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <p>Kindly confirm COD</p>

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
    <form action="{{ route("shipments.delivery", ['shipment' => $shipment]) }}" method="post" class="delivery-failed-form">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group delivery-reasons">
            <b class="mb-3 d-block">Why it isn't delivered?</b>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="rejected" name="status" value="rejected" required
                       class="custom-control-input" data-message="We're sorry for that, Please provide some details">
                <label class="custom-control-label" for="rejected">Rejected</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="not_available" name="status" value="not_available" required
                       class="custom-control-input"
                       data-message="We're sorry for wasting your time, Kindly provide some details">
                <label class="custom-control-label" for="not_available">Not Available</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="consignee_rescheduled" name="status" value="consignee_rescheduled" required
                       class="custom-control-input"
                       data-message="Kindly inform us about the requested time and any additional details">
                <label class="custom-control-label" for="consignee_rescheduled">Consignee Rescheduled</label>
            </div>
        </div>

        <div class="step-2" style="display: none;">
            <div class="message font-weight-bold mb-4 text-danger"></div>

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
