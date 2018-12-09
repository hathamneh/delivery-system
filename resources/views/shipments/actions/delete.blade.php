@php /** @var \App\Shipment $shipment */ @endphp

<form action="{{ route("shipments.destroy", ['shipment' => $shipment]) }}" class="delete-form" method="post">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
</form>
<fieldset class="shipment-actions-fieldset mt-4">
    <legend><i class="fa-trash"></i> @lang('shipment.delete')</legend>
    <div>
        @if($shipment->isEditable())
            <p>@lang('shipment.delete_notice')</p>
            <button type="button" class="btn btn-danger" data-toggle="modal"
                    data-target="#deleteShipment-{{ $shipment->id }}"><i
                        class="fa-trash"></i> @lang('shipment.delete')</button>
        @else
            <div class="alert alert-light">
                <i class="fa-exclamation-triangle"></i>
                The shipment cannot be deleted after it is delivered.
            </div>
        @endif
    </div>
</fieldset>
@component('bootstrap::modal',[
                        'id' => 'deleteShipment-'.$shipment->id
                    ])
    @slot('title')
        @lang('shipment.delete')?
    @endslot
    @lang('shipment.delete_notice')
    @slot('footer')
        <button class="btn btn-outline-secondary"
                data-dismiss="modal">@lang('common.cancel')</button>
        <form action="{{ route('shipments.destroy', [$shipment]) }}" method="post" class="ml-auto">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <button class="btn btn-danger" type="submit"><i
                        class="fa fa-trash"></i> @lang('shipment.delete')
            </button>
        </form>
    @endslot
@endcomponent