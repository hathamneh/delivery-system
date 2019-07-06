@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('notes') }}
@endsection

@section('pageTitle')
    <i class='fas fa-file'></i> @lang("note.label")
@endsection

@section('actions')
    <div class="ml-auto d-flex px-2 align-items-center">
        <div class="btn-group" role="group">
            <a href="{{ route('notes.create') }}" class="btn btn-secondary"><i
                        class="fa fa-plus-circle mr-2"></i> @lang('note.new')</a>
        </div>
    </div>
@endsection


@section('content')
    <nav class="nav inner-nav">
        <a href="{{ route('notes.index', ['tab'=>'public']) }}"
           class="{{ $tab != "public" ?: "active" }}">@lang('note.public_notes')</a>

        <a href="{{ route('notes.index', ['tab'=>'private']) }}"
           class="{{ $tab != "private" ?: "active" }}">@lang('note.private_notes')</a>

    </nav>
    <div class="container mt-4">
        @include("notes.list")
    </div>
@endsection