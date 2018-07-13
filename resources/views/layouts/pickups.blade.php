@extends('layouts.app')

@section('actions')
    <a href="{{ route('pickups.index') }}" class="btn btn-light">
        <i class="fa-shopping-bag"></i> <span>@lang('pickup.label')</span>
    </a>
    <a href="{{ route('pickups.create') }}" class="btn btn-primary"><i
                class="fa-plus-circle"></i> <span>@lang('pickup.create')</span>
    </a>
@endsection
