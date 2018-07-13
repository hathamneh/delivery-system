@extends('layouts.users')


@section('breadcrumbs')
    {{ Breadcrumbs::render('roles') }}
@endsection

@section('pageTitle')
    <i class='fas fa-user-secret'></i> @lang("user.roles.label")
@endsection


@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>@lang('user.roles.name')</th>
                <th>@lang('user.roles.description')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($templates as $template)
                <tr>
                    <td>{{ $template->id }}</td>
                    <td>{{ $template->name }}</td>
                    <td>{{ $template->description}}</td>
                    <td>
                        <div class="d-flex">
                            @if($template->editable)
                                <a href="{{ route('roles.edit', ['role'=>$template->id]) }}" data-toggle="tooltip"
                                   class="btn btn-light btn-sm" title="@lang('user.roles.edit')">
                                    <i class="fa fa-edit"></i></a>
                            @endif
                            @if($template->deletable)
                                <form action="{{ route('roles.destroy', ['role' => $template->id]) }}"
                                      method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-light btn-sm" title="@lang('user.roles.delete')"
                                            type="submit" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection