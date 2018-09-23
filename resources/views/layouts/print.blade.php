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
<div class="d-flex sticky-top">
    <div class="btn-group print-tools">
        <a href="javascript:" onclick="window.history.back()" class="btn btn-secondary btn-sm d-print-none"><i
                    class="fa-chevron-left mr-2"></i> @lang('common.back')</a>
        <a href="javascript:" onclick="window.print()" class="btn btn-primary btn-sm d-print-none"><i
                    class="fa-print mr-2"></i> @lang('common.print')</a>
        @if(isset($invoice))
            @if($invoice->type == "client")
                <button class="btn btn-success btn-sm d-print-none" {{ $invoice->client_paid ? "disabled" : "" }}
                title="@lang('client.client_paid_tooltip')" data-toggle="modal" data-target="#makePaidModal"><i
                            class="fa-check mr-2"></i> @lang('client.client_paid')</button>
            @elseif(isset($invoice) && $invoice->type == "courier")
                <button class="btn btn-success btn-sm d-print-none" {{ $invoice->courier_cashed ? "disabled" : "" }}
                title="@lang('courier.courier_cashed_tooltip')" data-toggle="modal" data-target="#makeCashedModal"><i
                            class="fa-check mr-2"></i> @lang('courier.courier_cashed')</button>
            @endif
        @endif
    </div>
</div>
@if(isset($invoice))
    @if($invoice->type == "client" && !$invoice->client_paid)
        @component('bootstrap::modal',[
                    'id' => 'makePaidModal'
                ])
            @slot('title')
                @lang('common.confirmation')
            @endslot
            <p><b>Are you sure to mark the shipments included in this invoice as paid for the selected client?</b></p>
            <small>You can revert this action in reports page.</small>
            @slot('footer')
                <button class="btn btn-outline-secondary"
                        data-dismiss="modal">@lang('common.cancel')</button>
                <form action="{{ route('accounting.paid', [$invoice]) }}" method="post" class="ml-auto">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <button class="btn btn-success" type="submit" name="type" value="client"><i
                                class="fa fa-check mr-2"></i> @lang('client.client_paid')
                    </button>
                </form>
            @endslot
        @endcomponent
    @elseif($invoice->type == "courier" && !$invoice->courier_cashed)
        @component('bootstrap::modal',[
                    'id' => 'makeCashedModal'
                ])
            @slot('title')
                @lang('common.confirmation')
            @endslot
            <p><b>Are you sure to mark the shipments included in this invoice as cashed for the selected courier?</b></p>
            <small>You can revert this action in reports page.</small>
            @slot('footer')
                <button class="btn btn-outline-secondary"
                        data-dismiss="modal">@lang('common.cancel')</button>
                <form action="{{ route('accounting.paid', [$invoice]) }}" method="post" class="ml-auto">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <button class="btn btn-success" type="submit" name="type" value="courier"><i
                                class="fa fa-check mr-2"></i> @lang('courier.courier_cashed')
                    </button>
                </form>
            @endslot
        @endcomponent
    @endif
@endif

<div id="content">
    @yield('content')
</div>

<script src="{{ mix('js/print.bundle.js') }}"></script>
@yield('beforeBody')

</body>
</html>