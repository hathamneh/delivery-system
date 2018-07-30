@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('notes') }}
@endsection

@section('pageTitle')
    <i class='fas fa-file'></i> @lang("note.label")
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('notes.store') }}" method="post">
            {{ csrf_field() }}
            @include('notes.form')
        </form>
    </div>
@endsection