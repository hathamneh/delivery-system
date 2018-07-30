@extends('layouts.couriers')


@section('breadcrumbs')
    {{ Breadcrumbs::render('couriers') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("couriers.label")
@endsection

@section('content')
    <form action="{{ route('couriers.update', ['courier' => $courier]) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        @include('couriers.form')
    </form>
@endsection
