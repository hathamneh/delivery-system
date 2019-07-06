@extends('layouts.clients')


@section('breadcrumbs')
    {{ Breadcrumbs::render('clients.create') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("client.create")
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('clients.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                @if ($errors->any())
                    <div class="col-md-8">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="col-md-8 mx-auto">

                    @include("clients.form.personal")
                    <hr>
                    @include('clients.form.zone')
                    <hr>
                    @include('clients.form.bank')
                    <hr>
                    @include('clients.form.limits')
                    <hr>
                    @include('clients.form.chargedFor')
                    <hr>
                    @include('clients.form.urls')
                    <hr>
                    @include('clients.form.emails')
                    <hr>
                    <p>
                        <b>Attachments</b>
                    </p>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" multiple name="client_files[]"
                               id="client_files">
                        <label class="custom-file-label" for="client_files">Choose file</label>
                    </div>

                    <hr>
                    @include('clients.form.notesForCourier')
                </div>
                <div class="col-md-3">
                    <div class="custom-sticky-top">
                        <div class="extra-form-info">
                            <label for="account_number"
                                   class="control-label font-weight-light">@lang('client.c_account_number')</label>
                            <div class="form-readonly">{{ $next_account_number ?? "" }}</div>
                        </div>
                        <div class="form-side-actions">
                            <button class="btn btn-outline-secondary"><i class="fa-times"></i> @lang('common.cancel')
                            </button>
                            <button class="btn btn-primary"><i class="fa-save"></i> @lang('client.save')</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection