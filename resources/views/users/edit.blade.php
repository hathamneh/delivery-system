@extends('layouts.users')

@section('breadcrumbs')
    {{ Breadcrumbs::render('users.edit', $user->id) }}
@endsection

@section('pageTitle')
    <i class='fas fa-users'></i> @lang("user.edit")
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
        @if (session('alert'))
            <div class="col-md-7 mx-auto">
                <div class="alert alert-{{ session('alert')->type }}">
                    {{ session('alert')->msg }}
                </div>
            </div>
        @endif

        <div class="col-md-7 mx-auto">
            <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-row">

                    <div class="form-group col-sm-6">

                        <label for="username">@lang('user.username')</label>
                        <input type="text" class="form-control" name="username" id="username"
                               placeholder="@lang('user.username')" value="{{ $user->username }}">

                    </div>
                    <div class="form-group col-sm-6">
                        <label for="email">@lang('user.email')</label>
                        <input type="email" class="form-control" name="email" id="email"
                               placeholder="@lang('user.email')" value="{{ $user->email }}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="password">@lang('user.password')</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password"
                                   autocomplete="off"
                                   placeholder="@lang('user.password')">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary show-password" type="button"
                                        data-toggle="tooltip"
                                        title="@lang('auth.show_password')"><i class="fa-eye"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="password">@lang('user.password_confirmation')</label>
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
                        <select name="template" id="template" class="custom-select" {{ $user->template->name == 'courier' || $user->template->name == 'client' ? 'disabled' : '' }}>
                            <option value="" disabled>@lang('common.select')</option>
                            @foreach($templates as $template)
                                <option {{ optional($user->template)->id == $template->id ? "selected" : "" }}
                                        value="{{ $template->id }}">{{ $template->name }}
                                    - {{ $template->description }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-save mr-md-2"></i><span
                            class="d-md-inline d-none">@lang('user._save.username')</span>
                </button>
            </form>
        </div>
    </div>
@endsection