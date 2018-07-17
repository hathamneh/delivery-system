@extends('layouts.app')

@section('actions')
    @yield('actionsFirst')
    <a href="{{ route('pickups.create') }}" class="btn btn-primary"><i
                class="fa-plus-circle"></i> <span>@lang('pickup.create')</span>
    </a>
@endsection
