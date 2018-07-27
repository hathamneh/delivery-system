@php /** @var \App\Shipment $shipment */ @endphp

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mx-auto mb-4">
                    <div class="status-{{ $shipment->status->group }}">
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
                            <span>{{ trans("shipment.statuses.".$shipment->status->name) }}</span>
                        </div>
                    </div>
                    <p class="status-description">{{ $shipment->status->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8 mx-auto">
            <h3>Shipment History</h3>
            <ul class="list-group shipment-history flex-column-reverse mt-3">
                @foreach($shipment->revisionHistory as $history)
                    @if($history->key == 'created_at' && !$history->old_value)
                        <li class="list-group-item">Shipment created at <span class="badge badge-secondary">{{ $history->newValue() }}</span></li>
                    @else
                        <li class="list-group-item">{{ ucfirst(trans("shipment.".$history->fieldName())) }} changed
                            from <span class="badge badge-secondary">{{ $history->oldValue() }}</span> to <span class="badge badge-secondary">{{ $history->newValue() }}</span>
                            <br>
                            <small class="text-muted">{{ $history->userResponsible() != null ? "By ". $history->userResponsible()->username . " at" : "At" }} {{ $history->created_at }}</small></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

</div>

