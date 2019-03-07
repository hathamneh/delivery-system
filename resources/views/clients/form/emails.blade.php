@php /** @var \App\Client $client */ @endphp
<section class="email-settings">
    <h3 class="mt-0 mb-3 font-weight-bold">@lang('client.emails')</h3>
    <div class="custom-control custom-checkbox custom-control-inline mb-3">
        <input type="checkbox" id="shipments-updates" name="shipments_email_updates" class="custom-control-input"
                {{ isset($client) && $client->shipments_email_updates ? 'checked' : '' }}>
        <label for="shipments-updates" class="custom-control-label">Receive shipment updates emails
            <br>
            <small class="text-muted">Client will receive email if a shipment is rejected or cancelled, etc.</small>
        </label>
    </div>
    <div class="input-group mb-2">
        <div class="form-row w-100">
            <div class="col-12">
                <label for="secondary_emails">@lang("client.secondary_emails")</label>
            </div>
            <div class="col-12">
                <textarea name="secondary_emails" id="secondary_emails" class="form-control"
                placeholder="@lang("client.secondary_emails_help")">{!! isset($client) ? implode(",", $client->secondary_emails) : "" !!}</textarea>
            </div>
        </div>
    </div>
</section>