@extends('layouts.app')

@section('actions')
    @yield('actionsFirst')
    <a href="{{ route('clients.index') }}" class="btn btn-light">
        <i class="fa-user-tie"></i> @lang('client.label')
    </a>
    <a href="{{ route('clients.create') }}" class="btn btn-primary"><i
                class="fa-user-plus"></i> @lang('client.create')</a>
@endsection
