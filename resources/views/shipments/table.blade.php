@if(auth()->user()->isCourier())
    @include('shipments.table.couriers')
@else
    @if(isset($applied) && isset($applied['types']) && in_array('returned', $applied['types'])))
        @include('shipments.table.returned')
    @else
        @include('shipments.table.default')
    @endif
@endif