<!DOCTYPE html >
<html class="@lang('base.dir')" dir="@lang('base.dir')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>{{ Config::get('app.name') }}</title>
    <link href="{{ mix('css/main.bundle.css') }}"
          rel="stylesheet">

    @yield('htmlHead')

    <script src="{{ asset('js/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>

<!-- BEGIN BODY -->
<body class="@lang('base.dir') {{{ $sidebarCollapsed ? "sidebar-collapsed" : "" }}} sidebar-condensed color-blue theme-sdtd fixed-topbar bg-clean dashboard">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<section>

    @include('layouts.partials.sidebar')

    <div class="main-content">

        @include('layouts.partials.topbar')

        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content page-thin">

            <div class="footer">
                <div class="copyright">
                    <p class="pull-left sm-pull-reset">
                        <span><?= __("FOOTER_COPY_RIGHT") ?></span>
                    </p>
                </div>
            </div>
        </div>
            <!-- END PAGE CONTENT -->
    </div>
    <!-- END MAIN CONTENT -->
</section>



<a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
<script src="{{ mix('js/main.bundle.js') }}"></script>

<?php if(function_exists("scripts")) scripts() ?>


</body>
</html>