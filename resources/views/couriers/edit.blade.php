@extends('layouts.couriers')


@section('breadcrumbs')
    {{ Breadcrumbs::render('couriers') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("courier.label")
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('couriers.update', ['courier' => $courier]) }}" method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            @include('couriers.form')
        </form>
    </div>
@endsection
