@extends('layouts.pickups')


@section('breadcrumbs')
    {{ Breadcrumbs::render('pickups') }}
@endsection

@section('pageTitle')
    <i class='fa-shopping-bag'></i> @lang("pickup.label")
@endsection

@section('actionsFirst')
    <div id="reportrange" class="btn btn-outline-secondary">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>
@endsection

@section('content')
    <div class="container">
        @component('pickups.pickups-list', ['pickups' => $pickups]) @endcomponent
    </div>
@endsection

@section('beforeBody')
    <script src="{{ asset('js/plugins/mixitup.min.js') }}"></script>
    <script>
        $(function () {

            window.drpOptions = {
                ranges: {
                    '@lang('common.today')': [moment(), moment()],
                    '@lang('common.yesterday')': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '@lang('common.last30days')': [moment().subtract(29, 'days'), moment()],
                    '@lang('common.thisMonth')': [moment().startOf('month'), moment().endOf('month')],
                    '@lang('common.lastMonth')': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                lifetimeRangeLabel: "@lang('common.lifetime')",
                locale: {
                    "format": "MM/DD/YYYY",
                    "separator": " - ",
                    "applyLabel": "@lang('common.apply')",
                    "cancelLabel": "@lang('common.cancel')",
                    "fromLabel": "@lang('common.from')",
                    "toLabel": "@lang('common.to')",
                    "customRangeLabel": "@lang('common.customRange')",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Su",
                        "Mo",
                        "Tu",
                        "We",
                        "Th",
                        "Fr",
                        "Sa"
                    ],
                    "monthNames": [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                    ],
                    "firstDay": 1
                }
            };

            window.lifetimeRangeLabel = "@lang('common.lifetime')";
            window.drpOptions.isLifetime = {{ !($startDate && $endDate) ? "true" : "false" }};
            if (!window.drpOptions.isLifetime) {
                window.drpOptions.startDate = moment("{{ $startDate }}");
                window.drpOptions.endDate = moment("{{ $endDate }}");
            }

        });
    </script>
    <script src="{{ asset('js/legacy/pickups.js') }}"></script>
@endsection