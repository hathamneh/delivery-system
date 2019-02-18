@php /** @var \App\Shipment $shipment */ @endphp

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mx-auto mb-4">
                    <div class="status-{{ $shipment->status->groups[0] }}">
                        <div class="shipment-lifecycle">
                            <div class="steps-circles">
                                <div class="step-wrapper">
                                    <div class="step processing"><i></i></div>
                                </div>
                                <div class="step-wrapper">
                                    <div class="step in_transit"><i></i></div>
                                </div>
                                <div class="step-wrapper">
                                    <div class="step delivered"><i></i></div>
                                </div>

                            </div>
                            <div class="steps-labels">
                                <div class="step-label processing">Processing</div>
                                <div class="step-label in_transit">In Transit</div>
                                <div class="step-label delivered">Delivered</div>
                            </div>
                        </div>
                        <div class="shipment-status">
                            <span>{{ trans("shipment.statuses.{$shipment->status->name}.name") }}</span>
                        </div>
                    </div>
                    <p class="status-description">{{ trans("shipment.statuses.{$shipment->status->name}.description") }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8 mx-auto">
            @include('shipments.partials.history')
        </div>
    </div>

</div>

