@extends('layouts.app')

@section('actions')
    @yield('actionsFirst')
    <a href="{{ route('couriers.index') }}" class="btn btn-light">
        <i class="fa-truck"></i> @lang('courier.label')
    </a>
    <a href="{{ route('couriers.create') }}" class="btn btn-primary"><i
                class="fa-plus-circle"></i> @lang('courier.create')</a>
@endsection
