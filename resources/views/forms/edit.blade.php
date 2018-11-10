@extends('layouts.app')


@section('breadcrumbs')
    {{ Breadcrumbs::render('forms.edit', $form) }}
@endsection

@section('pageTitle')
    <i class='fa-file'></i> @lang("forms.edit"): {{ $form->name }}
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
        <form action="{{ route('forms.update', [$form]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('forms.form')
        </form>
    </div>
@endsection