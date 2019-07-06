<div>
    <div class="form-group">
        <label for="text">@lang('note.text')</label>
        <textarea name="text" id="text" cols="30" rows="10" class="form-control"
                  placeholder="@lang('note.text')">{{ old('text') ?? $note->text ?? "" }}</textarea>
    </div>
    <div class="form-group">
        <label for="private">
                <input type="checkbox" name="private" id="private"
                        {{ (old('private') == "on" || (isset($note) && $note->private)) ? 'checked' : "" }}>
            Is Private?
            </label>
    </div>
    <button class="btn btn-primary">@lang('note.save')</button>
</div>