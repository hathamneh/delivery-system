@extends('layouts.couriers')


@section('breadcrumbs')
    {{ Breadcrumbs::render('couriers.create') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("courier.create")
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('couriers.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include('couriers.form')
        </form>
    </div>
@endsection
