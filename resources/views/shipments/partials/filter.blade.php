<div class="p-2">
    <div class="form-group">
        <label for="filter_status">@lang('shipment.status')</label>
        <select id="filter_status" class="form-control select2 w-100" multiple data-style="popover-select2">
            @foreach($statuses as $status)
                <option value="{{ $status->name }}" {{ in_array($status->name,$applied) ? "selected" : "" }}>@lang('shipment.statuses.'.$status->name)</option>
            @endforeach
        </select>
    </div>
    <form action="{{ request()->getRequestUri() }}" method="get">
        <input type="hidden" name="scope" value="">
        <button class="btn btn-sm btn-secondary" type="submit">Apply</button>
    </form>
</div>