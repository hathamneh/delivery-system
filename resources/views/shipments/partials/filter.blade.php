<div class="p-2">
    <div class="form-group">
        <label for="filter_status">@lang('shipment.status')</label>
        <select id="filter_status" class="form-control select2 w-100" multiple data-style="popover-select2" data-placeholder="Choose status">
            @foreach($statuses as $status)
                <option value="{{ $status->name }}" {{ in_array($status->name,$applied['scope']) ? "selected" : "" }}>@lang('shipment.statuses.'.$status->name)</option>
            @endforeach
        </select>
    </div>
    <form action="{{ request()->getRequestUri() }}" method="get">
        <div class="form-group">
            <label for="filter_client">@lang('client.account_number') / @lang('client.national_id')</label>
            <input type="text" class="form-control" name="client" id="filter_client" placeholder="Enter Value"
                   value="{{ $applied['client'] }}">
        </div>
        <input type="hidden" name="type" value="">
        <button class="btn btn-sm btn-secondary" type="submit">Apply</button>
    </form>
</div>