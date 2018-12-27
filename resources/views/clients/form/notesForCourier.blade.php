<div class="form-group">
    <label for="note_for_courier" class="font-weight-bold">@lang('client.notes_for_courier')</label>
    <textarea name="note_for_courier" id="notes_for_courier" class="form-control" placeholder="@lang('client.notes_for_courier')">{{ isset($client) ? $client->note_for_courier : "" }}</textarea>
</div>