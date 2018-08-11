@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('settings') }}
@endsection

@section('pageTitle')
    <i class='fas fa-cogs'></i> {{ config('app.name') }} @lang("settings.label")
    <small class="title-warning" data-toggle="tooltip" title="@lang('settings.notice')"><i class="fa-exclamation"></i></small>
@endsection

@section('content')
    <nav class="nav inner-nav">
        <a href="{{ route('settings.index', ['tab'=>'general']) }}"
           class="{{ $tab != "general" ?: "active" }}"><i class="fa-info-circle"></i> @lang('settings.general.label')</a>
    </nav>
    <div class="container-fluid">
        @includeWhen($tab=='general', 'settings.tabs.general')

    </div>
@endsection