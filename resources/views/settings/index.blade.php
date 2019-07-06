@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('settings') }}
@endsection

@section('pageTitle')
    <i class='fas fa-cogs'></i> {{ config('app.name') }} @lang("settings.label")
    <small class="title-warning" data-toggle="tooltip" title="@lang('settings.notice')"><i class="fa-exclamation"></i>
    </small>
@endsection

@section('content')
    <nav class="nav inner-nav">
        <a href="{{ route('settings.index', ['tab'=>'company']) }}"
           class="{{ $tab != "company" ?: "active" }}"><i class="fa-info-circle"></i> @lang('settings.company.label')
        </a>
        <a href="{{ route('settings.index', ['tab'=>'accounting']) }}"
           class="{{ $tab != "accounting" ?: "active" }}"><i class="fa-info-circle"></i> @lang('settings.accounting.label')
        </a>
        <a href="{{ route('settings.index', ['tab'=>'branches']) }}"
           class="{{ $tab != "branches" ?: "active" }}"><i class="fa-info-circle"></i> @lang('branch.label')
        </a>
    </nav>
    <div class="container-fluid">
        @includeif('settings.tabs.' . $tab)
    </div>
@endsection