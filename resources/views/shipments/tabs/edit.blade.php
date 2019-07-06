<div class="container-fluid shipment-details">
    @if(!$shipment->isEditable())
        <div class="row">
            <div class="col-md-7 mx-auto my-4">
                <div class="alert alert-light text-center py-4">
                    <i class="fa-exclamation-triangle mb-4 d-inline-block" style="font-size: 2rem"></i>
                    <br>
                    The shipment cannot be edited in its current state.
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills flex-row flex-md-column mb-2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details"
                       role="tab" aria-controls="details" aria-selected="true">@lang('shipment.details')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="delivery-tab" data-toggle="tab" href="#delivery"
                       role="tab" aria-controls="delivery"
                       aria-selected="false">@lang('shipment.delivery_details')</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="tab-content">
                <div class="tab-pane active show fade" role="tabpanel" aria-labelledby="details-tab" id="details">
                    @if($shipment->isEditable())
                        <form action="{{ route('shipments.update', ['shipment'=>$shipment->id, "tab"=>"details"]) }}"
                              method="post">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            @endif
                            @include('shipments.wizard.details')
                            <div class="my-1">
                                <button class="btn btn-primary"
                                        type="submit" {{ $shipment->isEditable() ?: 'disabled' }}><i
                                            class="fa-save"></i> @lang('common.save_changes')</button>
                            </div>
                            @if($shipment->isEditable())
                        </form>
                    @endif
                </div>
                <div class="tab-pane fade" role="tabpanel" aria-labelledby="delivery-tab" id="delivery">
                    @if($shipment->isEditable())
                        <form action="{{ route('shipments.update', ['shipment'=>$shipment->id, "tab"=>"delivery"]) }}"
                              method="post">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            @endif
                            @include('shipments.wizard.delivery')
                            <div class="my-1">
                                <button class="btn btn-primary"
                                        type="submit" {{ $shipment->isEditable() ?: 'disabled' }}><i
                                            class="fa-save"></i> @lang('common.save_changes')</button>
                            </div>
                            @if($shipment->isEditable())
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>