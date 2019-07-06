<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="name" class="control-label">@lang('forms.name')</label>
                    <input type="text" name="name" id="name" placeholder="@lang('forms.name')"
                           class="form-control" value="{{ $form->name ?? old('name') }}">
                </div>
                <div class="form-group">
                    <label for="description" class="control-label">@lang('forms.description')</label>
                    <textarea name="description" id="description" placeholder="@lang('forms.description')"
                              class="form-control">{{ $form->description ?? old('description') }}</textarea>
                </div>
            </div>
            <div class="col-md-7">
                <label>@lang('forms.file')</label>
                @if(isset($form) && !is_null($form->attachment))
                    @if($form->attachment->type === "pdf")
                        <object data="{{ $form->attachment->url }}" type="application/pdf" width="100%" height="550">
                            <a href="{{ $form->attachment->url }}" class="btn btn-info">Download PDF</a>
                        </object>
                    @else
                        <div>
                        <a href="{{ $form->attachment->url }}" class="btn btn-link">{{ $form->attachment->name }}</a>
                        </div>
                    @endif
                    <label class="mt-2">Change document:</label>
                @endif
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="form_file"
                           id="form_file">
                    <label class="custom-file-label" for="form_file">Choose file</label>
                </div>
            </div>
            <div class="col-md-12 d-flex mt-3">
                <button type="submit" class="ml-auto btn btn-primary">@lang('forms.save')</button>
            </div>
        </div>
    </div>
</div>