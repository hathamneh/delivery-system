@extends('layouts.app')

@section('actions')
    <div class="btn-group">
        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fa-users"></i> @lang('user.label')
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('users.index') }}">@lang('user.all')</a>
            @foreach($templates as $template)
                <a class="dropdown-item"
                   href="{{ route('users.index', ['template' => $template->id]) }}">{{ str_plural($template->description) }}</a>
            @endforeach
        </div>
    </div>
    <a href="{{ route('roles.index') }}" class="btn btn-light"><i
                class="fa-user-secret"></i> @lang('user.roles.label')</a>
    <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fa-plus"></i> @lang('common.new')
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('users.create') }}"><i
                        class="fa-user-plus"></i>@lang('user.add_new')</a>
            <a class="dropdown-item" href="{{ route('roles.create') }}"><i
                        class="fa-plus-circle"></i>@lang('user.roles.add_new')</a>
        </div>
    </div>
@endsection
