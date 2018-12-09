<div class="form-row">
    <div class="form-group col-sm-12">
        @include('clients.form.attachments')
    </div>
    <div class="form-group col-sm-12">
        <hr>
        <label class="control-label">@lang('client.upload_file')</label>
        <form action="{{ route('clients.update', ['client' => $client, 'section' => 'attachments']) }}" method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="custom-file">
                <input type="file" class="custom-file-input" multiple name="client_files[]"
                       id="client_files">
                <label class="custom-file-label" for="client_files">Choose file</label>
            </div>
            <button class="btn btn-primary"><i class="fa-save"></i> @lang('client.upload')</button>
        </form>
    </div>
</div>
