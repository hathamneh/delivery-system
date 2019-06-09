@extends('layouts.users')

@section('breadcrumbs')
    {{ Breadcrumbs::render('users') }}
@endsection

@section('pageTitle')
    <i class='fas fa-users'></i> @lang("user.label")
@endsection

@section('content')
    <div class="container-fluid">
        <div class="table-responsive py-2 px-1">
            <table class="table dataTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>@lang('user.username')</th>
                    <th>@lang('user.name')</th>
                    <th>@lang('user.email')</th>
                    <th>@lang('user.password')</th>
                    <th>@lang('user.template')</th>
                    <th>@lang('common.actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr id="user-{{ $user->id }}" data-id="{{ $user->id }}">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->isCourier() || $user->isClient() ? $user->display_name : '' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->the_password }}</td>
                        <td>{{ $user->template->name ?? "" }} - {{ $user->template->description ?? "" }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('users.edit', ['user'=>$user->id]) }}"
                                   class="btn btn-light btn-sm" title="@lang('user.edit')">
                                    <i class="fa fa-edit"></i></a>
                                <button class="btn btn-light btn-sm" title="@lang('user.delete')" type="button"
                                        data-toggle="tooltip" data-target="#deleteUser-{{ $user->id }}"><i class="fa fa-trash"></i>
                                </button>
                                @component('layouts.components.deleteItem', [
                                    'name' => 'user',
                                    'id' => $user->id,
                                    'action' => route('couriers.destroy', [$user])
                                ])@endcomponent
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection