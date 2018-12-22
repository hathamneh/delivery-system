@extends('layouts.clients')


@section('breadcrumbs')
    {{ Breadcrumbs::render('clients.show', $client) }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> {{ $pageTitle }}
@endsection

@section('actionsFirst')
    @if($tab == "statistics")
        <div id="reportrange" class="btn btn-outline-secondary" data-start-date="{{ $startDate}}"
             data-end-date="{{ $endDate}}" data-lifetime-range="false">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    @endif
@endsection

@section('content')
    @include('clients.componenets.client-tabs')

    <div class="container mt-4">
        @includeWhen($tab == "statistics", "clients.statistics")
        @includeWhen($tab == "shipments", "clients.shipments.index")
        @includeWhen($tab == "pickups", "clients.pickups.index")
        @includeWhen($tab == "zones", "clients.zones.index")
        @includeWhen($tab == "services", "clients.services.index")
    </div>
@endsection

@section('beforeBody')
    @if($tab == "statistics")
        <script>
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: [{!! implode(',',$statistics->statuses['labels'])  !!}],
                    datasets: [{
                        label: '@lang('client.statusesPercentage')',
                        data: [{!! implode(',', $statistics->statuses['values']) !!}],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 70, 64, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(100, 255, 64, 0.2)',
                            'rgba(50, 50, 50, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 50, 64, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(50, 225, 64, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            display: true,
                            ticks: {
                                min: 0,
                                stepSize: 1,
                                suggestedMax: 5
                            }
                        }]
                    },
                }
            });
        </script>
    @endif
@endsection