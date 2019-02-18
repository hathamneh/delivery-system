<div class="reports-actions disabled">
    <form class="actions-content" action="{{ route('reports.update') }}" method="post">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <input type="hidden" name="shipments" value="">
        <div class="selection-indicator">@lang('reports.with_selected')</div>
        <div class="btn-group btn-group-sm" role="group">
            <div class="btn-group dropdown" role="group" >
                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="changeStatusDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                    @lang('shipment.change_status')
                </button>
                <div class="dropdown-menu" aria-labelledby="changeStatusDropdown">
                    @foreach($statuses as $status)
                        <button name="status" type="submit" class="dropdown-item"
                                value="{{ $status->id }}">@lang("shipment.statuses.{$status->name}.name")</button>
                    @endforeach
                </div>
            </div>

            <button name="clientPaid" type="submit" class="btn btn-light" disabled
                    value="true">@lang('shipment.toggle_client_paid')</button>
            <button name="courierCashed" type="submit" class="btn btn-light" disabled
                    value="true">@lang('shipment.toggle_courier_cashed')</button>
        </div>
    </form>
</div>
<div id="reportrange" class="btn btn-outline-secondary" data-lifetime-range="true">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>