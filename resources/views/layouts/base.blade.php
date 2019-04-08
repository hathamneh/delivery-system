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
@yield('base')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>
    <script>
        $('#mailEditor').summernote();
    </script>
</body>
</html>