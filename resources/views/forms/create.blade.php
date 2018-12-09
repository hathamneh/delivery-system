@extends('layouts.app')


@section('breadcrumbs')
    {{ Breadcrumbs::render('forms.create') }}
@endsection

@section('pageTitle')
    <i class='fa-file'></i> @lang("forms.create")
@endsection

@section('content')
    <div class="container">

        @foreach ($errors->all() as $message)
            @component('bootstrap::alert', [
                'type' => "danger",
                'dismissible' => true,
                'animate' => true,
               ])
                {!! $message  !!}
            @endcomponent
        @endforeach
        <form action="{{ route('forms.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('forms.form')
        </form>
    </div>
@endsection