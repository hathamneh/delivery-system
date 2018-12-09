@extends('layouts.users')

@section('breadcrumbs')
    {{ Breadcrumbs::render('users.create') }}
@endsection

@section('pageTitle')
    <i class='fas fa-users'></i> @lang("user.new")
@endsection


@section('content')
    <div class="row">

        @if ($errors->any())
            <div class="col-md-7 mx-auto">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="col-md-7 mx-auto">
            <form action="{{ route('users.store') }}" method="post">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="username">@lang('user.username')</label>
                        <input type="text" class="form-control" name="username" id="username"
                               placeholder="@lang('user.username')">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="email">@lang('user.email')</label>
                        <input type="email" class="form-control" name="email" id="email"
                               placeholder="@lang('user.email')">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="password">@lang('user.password')</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password"
                                   placeholder="@lang('user.password')">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary show-password" type="button"
                                        data-toggle="tooltip"
                                        title="@lang('auth.show_password')"><i class="fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="password_confirmation">@lang('user.password_confirmation')</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="@lang('user.password_confirmation')">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary show-password" type="button"
                                        data-toggle="tooltip"
                                        title="@lang('auth.show_password')"><i class="fa-eye"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="template">@lang('user.roles.select')</label>
                        <select name="template" id="template" class="custom-select">
                            <option value="" selected disabled>@lang('common.select')</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}
                                    - {{ $template->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex mt-3 justify-content-end">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-save mr-2"></i> @lang('user.save')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection