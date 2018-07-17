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
    <div class="scrollable-nav__wrapper">
        <ul class="nav nav-pills scrollable-nav pickup-pills" id="pickupsTabs">
            <li class="nav-item">
                <a class="nav-link active" id="all-tab" href="#" data-toggle="tab" role="tab" data-mixitup-control
                   aria-selected="true" data-filter="all"><span>@lang('pickup.all')</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pending-tab" data-toggle="tab" href="#" role="tab" data-filter=".pickup-pending"
                   data-mixitup-control
                   aria-selected="false"><i class="fa-clock"></i><span>@lang('pickup.pending')</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="declined-tab" data-toggle="tab" href="#" role="tab"
                   data-filter=".pickup-declined" data-mixitup-control
                   aria-selected="false"><i class="fa-minus-circle"></i><span>@lang('pickup.declined')</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="completed-tab" data-toggle="tab" href="#" role="tab"
                   data-filter=".pickup-completed" data-mixitup-control
                   aria-selected="false"><i class="fa-check-circle2"></i><span>@lang('pickup.completed')</span></a>
            </li>
        </ul>
    </div>
    <div class="my-3">
        @component('pickups.pickups-list', ['pickups' => $pickups]) @endcomponent
    </div>

@endsection

@section('beforeBody')
    <script src="{{ asset('js/plugins/mixitup.min.js') }}"></script>
    <script>
        $(function() {

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