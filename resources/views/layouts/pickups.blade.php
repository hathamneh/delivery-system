@extends('layouts.app')

@section('actions')
    @if(auth()->user()->isAdmin())
        @yield('actionsFirst')
        <a href="{{ route('pickups.create') }}" class="btn btn-primary"><i
                    class="fa-plus-circle"></i> <span>@lang('pickup.create')</span>
        </a>
    @endif
@endsection
