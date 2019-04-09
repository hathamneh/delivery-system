@php /** @var \App\Shipment $shipment */ @endphp
<div class="container">
    <div class="row mt-4" data-id="{{ $shipment->id }}">

        @if ($errors->any())
            <div class="col-md-7 mx-auto">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="mx-auto col-md-9">

            @if(auth()->user()->isCourier() && auth()->user()->can('update', $shipment))
                @include("shipments.actions.courierConfirm")
                @include('shipments.actions.changeStatus', ["formAction" => route("shipments.delivery", ['shipment' => $shipment])])
            @endif

            @can('delete', $shipment)
                @include("shipments.actions.courierConfirm")
                @include('shipments.actions.changeStatus', ["formAction" => route("shipments.delivery", ['shipment' => $shipment])])
                @include('shipments.actions.return')
                @include('shipments.actions.delete')
            @endcan

        </div>
    </div>
</div>
