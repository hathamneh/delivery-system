@extends('layouts.clients')


@section('breadcrumbs')
    {{ Breadcrumbs::render('clients.show', $client) }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> {{ $pageTitle }}
@endsection

@section('content')
    @include('clients.componenets.client-tabs')

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-2">
                <ul class="nav nav-pills flex-row flex-md-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link {{ $section != 'personal' ?: 'active' }}" id="personal-tab"
                           href="{{ route('clients.edit', [$client, 'personal']) }}">@lang('client.personal')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $section != 'accounting' ?: 'active' }}" id="accounting-tab"
                           href="{{ route('clients.edit', [$client, 'accounting']) }}">@lang('client.accounting')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $section != 'emails' ?: 'active' }}" id="emails-tab"
                           href="{{ route('clients.edit', [$client, 'emails']) }}">@lang('client.emails')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $section != 'attachments' ?: 'active' }}" id="attachments-tab"
                           href="{{ route('clients.edit', [$client, 'attachments']) }}">@lang('client.attachments')</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())

                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @includeIf('clients.edit-tabs.' . $section)
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
