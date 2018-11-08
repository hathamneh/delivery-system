@extends('layouts.app')


@section('breadcrumbs')
    {{ Breadcrumbs::render('forms.create') }}
@endsection

@section('pageTitle')
    <i class='fa-file'></i> @lang("forms.create")
@endsection

@section('content')
    <div class="container">

        @foreach ($errors->all() as $message)
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @endforeach
        <form action="{{ route('forms.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">@lang('forms.name')</label>
                                <input type="text" name="name" id="name" placeholder="@lang('forms.name')"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label">@lang('forms.description')</label>
                                <textarea name="description" id="description" placeholder="@lang('forms.description')"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>@lang('forms.file')</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="form_file"
                                       id="form_file">
                                <label class="custom-file-label" for="form_file">Choose file</label>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex">
                            <button type="submit" class="ml-auto btn btn-primary">@lang('forms.save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection