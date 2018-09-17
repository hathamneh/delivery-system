@extends('layouts.pickups')


@section('breadcrumbs')
    {{ Breadcrumbs::render('pickups.edit', $pickup->id) }}
@endsection

@section('pageTitle')
    <i class='fa-shopping-bag'></i> @lang("pickup.edit")
@endsection

@section('actionsFirst')
    <a href="{{ route('pickups.index') }}" class="btn btn-light">
        <i class="fa-shopping-bag"></i> <span>@lang('pickup.all')</span>
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <form action="{{ route('pickups.update', ['pickup' => $pickup->id]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    @include('pickups.form')
                </form>
            </div>
        </div>
    </div>
@endsection
