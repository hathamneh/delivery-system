<div>
    <div class="form-group">
        <label for="text">@lang('note.text')</label>
        <textarea name="text" id="text" cols="30" rows="10" class="form-control"
                  placeholder="@lang('note.text')">{{ old('text') ?? $note->text ?? "" }}</textarea>
    </div>
    <div class="form-group">
        <label for="type">@lang('note.type')</label>
        <div class="input-group-prepend btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-secondary active"
                   title="@lang('note.public')">
                <input type="radio" name="type"
                       id="type_public" autocomplete="off" value="public"
                        {{ (!old('type') || old('type') == "public" || (isset($note) && !$note->private)) ? 'checked' : "" }}>
                @lang('note.public')
            </label>
            <label class="btn btn-outline-secondary"
                   title="@lang('note.private')">
                <input type="radio" name="type"
                       id="type_private" autocomplete="off" value="private"
                        {{ (old('type') == "private" || (isset($note) && $note->private)) ? 'checked' : "" }}>
                @lang('note.private')
            </label>
        </div>
    </div>
    <button class="btn btn-primary">@lang('note.save')</button>
</div>