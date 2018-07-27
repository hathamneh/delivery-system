<div class="container shipment-details">
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills flex-row flex-md-column mb-2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details"
                       role="tab" aria-controls="details" aria-selected="true">@lang('shipment.details')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="delivery-tab" data-toggle="tab" href="#delivery"
                       role="tab" aria-controls="delivery" aria-selected="false">@lang('shipment.delivery_details')</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="tab-content">
                <div class="tab-pane active show fade" role="tabpanel" aria-labelledby="details-tab" id="details">
                    <form action="{{ route('shipments.update', ['shipment'=>$shipment->id, "tab"=>"details"]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        @include('shipments.wizard.details')
                        <div class="my-1">
                            <button class="btn btn-primary" type="submit"><i class="fa-save"></i> @lang('common.save_changes')</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" role="tabpanel" aria-labelledby="delivery-tab" id="delivery">
                    <form action="{{ route('shipments.update', ['shipment'=>$shipment->id, "tab"=>"delivery"]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        @include('shipments.wizard.delivery')
                        <div class="my-1">
                            <button class="btn btn-primary" type="submit"><i class="fa-save"></i> @lang('common.save_changes')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>