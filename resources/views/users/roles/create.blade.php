@extends('layouts.users')

@section('breadcrumbs')
    {{ Breadcrumbs::render('roles.create') }}
@endsection

@section('pageTitle')
        <i class='fas fa-user-secret'></i> @lang("user.roles.add_new")
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <form action="{{ route('roles.store') }}" method="post">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="name">@lang('user.roles.name')</label>
                        <input type="text" class="form-control" name="name" id="name"
                               placeholder="@lang('user.roles.name')">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="description">@lang('user.roles.description')</label>
                        <textarea class="form-control" name="description" id="description"
                                  placeholder="@lang('user.roles.description')"></textarea>
                    </div>
                    <div class="col-sm-12">
                        <label>@lang('user.roles.permissions')</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($roles as $role)
                                        <div class="col-md-3"><b>{{ $role->name }}</b></div>
                                        <div class="col-md-7 d-flex mb-3">
                                            <input id="{{ $role->name }}" name="roles[{{ $role->id }}]" type="text"
                                                   data-provide="slider"
                                                   data-slider-ticks="[0, 1, 2, 3, 4]"
                                                   data-slider-ticks-labels='["@lang('user.roles.no_access')","@lang('user.roles.view')", "@lang('user.roles.create')", "@lang('user.roles.update')", "@lang('user.roles.delete')"]'
                                                   data-slider-min="0"
                                                   data-slider-max="3"
                                                   data-slider-step="1"
                                                   data-slider-value="{{ $role->default }}"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit"><i class="fa-save mr-2"></i> @lang('user.roles.save')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('beforeBody')

@endsection