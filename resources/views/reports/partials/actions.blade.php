<div class="reports-actions disabled">
    <form class="actions-content" action="{{ route('reports.update') }}" method="post">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <input type="hidden" name="shipments" value="">
        <div class="selection-indicator">@lang('reports.with_selected')</div>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-warning" disabled data-toggle="modal" data-target="#changeStatusModal"
                    value="true">@lang('shipment.change_status')</button>

            @if(!isset($client_paid) || $client_paid == true)
                <button name="clientPaid" type="submit" class="btn btn-light" disabled
                        value="true">@lang('shipment.toggle_client_paid')</button>
            @endif
            <button name="courierCashed" type="submit" class="btn btn-light" disabled
                    value="true">@lang('shipment.toggle_courier_cashed')</button>
        </div>
    </form>
</div>
@if(!isset($daterange) || $daterange == true)
<div id="reportrange" class="btn btn-outline-secondary" data-lifetime-range="true">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>
@endif