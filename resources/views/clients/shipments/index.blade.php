<div class="d-flex">
    <h2 class="font-weight-bold m-0">Client Shipments</h2>
    <div class="ml-auto">
        <button class="btn btn-outline-secondary shipments-filter-btn dropdown-toggle" type="button"
                data-toggle="popover" data-placement="bottom" data-html="true"
                data-content='@include('shipments.partials.filter', $filtersData)' data-title="Filter Shipments">
            <i class="fa-filter mr-2"></i> Filter
        </button>
        <div id="reportrange" class="btn btn-outline-secondary">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    </div>
</div>
<hr>
@include("shipments.table")