@extends('layouts.pickups')


@section('breadcrumbs')
    {{ Breadcrumbs::render('pickups.create') }}
@endsection

@section('pageTitle')
    <i class='fa-shopping-bag'></i> @lang("pickup.new")
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <form action="{{ route('pickups.store') }}" method="post">
                {{ csrf_field() }}
                @include('pickups.form')
            </form>
        </div>
    </div>
@endsection
