<!DOCTYPE html >
<html class="@lang('common.dir')" dir="@lang('common.dir')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>{{ (isset($pageTitle) ? $pageTitle . " - " : "") . Config::get('app.name') }}</title>
    <link href="{{ mix('css/main.bundle.css') }}" rel="stylesheet">
    <link href="{{ mix('css/print.css') }}" rel="stylesheet" media="print">

    @yield('htmlHead')
</head>

<!-- BEGIN BODY -->
<body class="@lang('common.dir') print-layout">
<a href="javascript:" onclick="window.history.back()" class="btn btn-light btn-sm d-print-none"><i
            class="fa-chevron-left mr-2"></i> @lang('common.back')</a>

<div id="content">
    @yield('content')
</div>
{{--<section>

    <div class="main-content">



        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content page-thin">



            <div class="footer d-print-none">
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
</section>--}}

@yield('beforeBody')


</body>
</html>