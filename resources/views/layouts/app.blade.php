<!DOCTYPE html >
<html class="@lang('common.dir')" dir="@lang('common.dir')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>{{ (isset($pageTitle) ? $pageTitle . " - " : "") . Config::get('app.name') }}</title>
    <link href="{{ mix('css/main.bundle.css') }}" rel="stylesheet">

    @yield('htmlHead')
</head>

<!-- BEGIN BODY -->
<body class="@lang('common.dir') {{{ isset($sidebarCollapsed) && $sidebarCollapsed ? "sidebar-collapsed" : "" }}} sidebar-condensed color-blue theme-sdtd
    fixed-topbar fixed-sidebar bg-clean dashboard">

<section>

    @include('layouts.partials.sidebar')

    <div class="main-content">

        @include('layouts.partials.topbar')

        <div class="page-heading {{ $pageHeadingClass ?? "" }}">
            @yield('breadcrumbs')
            <div class="page-heading__title">
                <h3>@yield('pageTitle')</h3>
                <div class="page-heading__actions">
                    @yield('actions')
                </div>
            </div>

        </div>
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content page-thin">

            @yield('content')

            <div class="footer">
                <div class="container-fluid">
                    <div class="copyright">
                        <p class="pull-left sm-pull-reset">
                            <span>@lang("common.footer_copyright")</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END MAIN CONTENT -->
</section>

@include('layouts.partials.search')

<!-- BEGIN PRELOADER -->
<div class="loader-overlay">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<!-- END PRELOADER -->

@component('bootstrap::modal',[
                        'id' => 'logoutModal'
                    ])
    @slot('title')
        @lang('auth.logout')?
    @endslot
    @lang('auth.logout_confirm')
    @slot('footer')
        <button class="btn btn-outline-secondary"
                data-dismiss="modal">@lang('common.cancel')</button>
        <form action="{{ route('logout') }}" method="post" class="ml-auto">
            {{ csrf_field() }}
            <button class="btn btn-danger" type="submit"><i
                        class="icon-power"></i> @lang('auth.logout')
            </button>
        </form>
    @endslot
@endcomponent


<a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>

<script src="{{ mix('js/main.bundle.js') }}"></script>

@yield('beforeBody')


</body>
</html>