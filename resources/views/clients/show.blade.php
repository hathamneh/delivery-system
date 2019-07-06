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

    <div class="container-fluid mt-4">
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
                    @foreach($statistics->statuses['values'] as $status => $values)
            var ctx = document.getElementById("{{ $status }}Chart").getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [{!! implode(',',$statistics->statuses['labels'])  !!}],
                    datasets: [
                        {
                            label: "{{ $values['label'] }}",
                            data: {!! json_encode(array_values($values['data'])) !!}
                        },
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
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
            @endforeach
        </script>
    @endif
@endsection