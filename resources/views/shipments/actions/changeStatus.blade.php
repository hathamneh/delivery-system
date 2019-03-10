<form action="{{ $formAction }}" method="post" class=" mt-4">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <fieldset class="shipment-actions-fieldset">
        <legend>@lang("shipment.change_status_manually")</legend>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="status">@lang('shipment.status')</label>
                <select name="status" id="status" class="selectpicker form-control status-changer"
                        data-target="#statusNotes" data-status-suggest
                        data-live-search="true">
                    <option value="" disabled selected>@lang("common.select")</option>
                    @foreach($statuses as $group => $values)
                        <optgroup label="@lang("shipment.status_groups.$group")">
                            @foreach($values as $status)
                                @if($status->name != "returned")
                                    <option data-subtext="@lang("shipment.statuses.{$status->name}.description")"
                                            value="{{ $status->name }}">@lang("shipment.statuses.{$status->name}.name")</option>
                                @endif
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div id="statusNotes" class="col-sm-12" style="display: none;">
                <div class="form-row">

                    <div class="form-group col-md-6 delivered">
                        <label for="actual_paid">How much did the consignee pay ?</label>
                        <input type="number" data-type="number" step="any" name="actual_paid" id="actual_paid"
                               class="form-control"
                               required
                               placeholder="@lang('shipment.actual_paid')" min="{{ $shipment->cash_on_delivery ?? "" }}"
                               max="{{ $shipment->cash_on_delivery ?? "" }}">
                    </div>

                    <div class="form-group col-md-6 rejected collected_from_office">
                        <label for="actual_paid">How much did the consignee pay ?</label>
                        <input type="number" data-type="number" step="any" name="actual_paid" id="actual_paid"
                               class="form-control"
                               required
                               placeholder="@lang('shipment.actual_paid')" min="0">
                    </div>

                    @php $setBranchStatuses = ""; @endphp
                    @foreach($statuses as $group => $values)
                        @foreach($values as $status)
                            @php /** @var \App\Status $status */ @endphp
                            @if(isset($status->options['set_branch']))
                                @php $setBranchStatuses .= $status->name . " "; @endphp
                            @endif

                            @if(isset($status->options['set_delivery_date']))
                                <div class="form-group col-6 deliveryDate-input {{ $status->name }}">
                                    <label for="delivery_date">When the new delivery date?</label>
                                    <input type="text" data-type="text" name="delivery_date" id="delivery_date"
                                           class="form-control datetimepicker"
                                           placeholder="@lang('shipment.delivery_date')">
                                </div>
                            @endif

                            @if(isset($status->options['select']))
                                @foreach($status->options['select'] as $name => $choices)
                                    <div class="form-group col-6 {{ $status->name }}">
                                        <label for="{{ $status->name . "_" . $name }}">@lang("shipment.statuses_options.{$name}")</label>
                                        <select class="selectpicker form-control"
                                                name="_notes[{{ $name }}]"
                                                id="{{ $status->name . "_" . $name }}">
                                            @foreach($choices as $choice)
                                                <option value="{{ $choice }}">{{ $choice }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            @endif

                            @if(isset($status->options['set_branch']))
                                @php $setBranchStatuses .= $status->name . " "; @endphp
                            @endif
                        @endforeach
                    @endforeach

                    <div class="form-group col-6 {{ $setBranchStatuses }}">
                        <label for="set_branch">@lang("shipment.statuses_options.set_branch")</label>
                        <select name="branch" id="set_branch" class="form-control">
                            @foreach($branches as $branch)
                                @php /** @var \App\Branch $branch */ @endphp
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12 statusNotes-field all">
                        <label for="status_notes">@lang('shipment.extra_notes')
                            <small class="text-muted">(Optional)</small>
                        </label>
                        <textarea name="status_notes" id="status_notes" class="form-control"
                                  data-target-for="statusSuggs" rows="4"
                                  placeholder="@lang('shipment.extra_notes')"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <button class="btn btn-primary" type="submit">@lang('shipment.change_status')</button>
        </div>
    </fieldset>
</form>