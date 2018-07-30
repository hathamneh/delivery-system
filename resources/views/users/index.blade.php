@extends('layouts.users')

@section('breadcrumbs')
    {{ Breadcrumbs::render('users') }}
@endsection

@section('pageTitle')
    <i class='fas fa-users'></i> @lang("user.label")
@endsection

@section('content')
    <div class="container">
        <div class="table-responsive py-2 px-1">
            <table class="table dataTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>@lang('user.username')</th>
                    <th>@lang('user.email')</th>
                    <th>@lang('user.template')</th>
                    <th>@lang('common.actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr id="user-{{ $user->id }}" data-id="{{ $user->id }}">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->template->name ?? "" }} - {{ $user->template->description ?? "" }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('users.edit', ['user'=>$user->id]) }}"
                                   class="btn btn-light btn-sm" title="@lang('user.edit')">
                                    <i class="fa fa-edit"></i></a>
                                <form class="delete-form" action="{{ route('users.destroy', ['user' => $user->id]) }}"
                                      method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                                <button class="btn btn-light btn-sm" title="@lang('user.delete')" type="button"
                                        data-delete="{{ $user->id }}" data-toggle="tooltip"><i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection