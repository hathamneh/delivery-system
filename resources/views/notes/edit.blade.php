@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('notes') }}
@endsection

@section('pageTitle')
    <i class='fas fa-file'></i> @lang("note.label")
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('notes.update', $note) }}" method="post">
            @csrf
            {{ method_field("put") }}
            @include('notes.form')
        </form>
    </div>
@endsection