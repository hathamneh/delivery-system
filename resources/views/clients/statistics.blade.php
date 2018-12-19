@if(isset($alert) && $alert)

    @component('bootstrap::alert', [
        'type' => $alert->type ?? "primary",
        'dismissible' => true,
        'animate' => true,
       ])
        {{ $alert->msg }}
    @endcomponent

@endif

@include('layouts.partials.overviewStats')

<div class="container mt-3 p-xs-0">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h3>Shipment Statuses</h3>
            <canvas id="myChart" width="900" height="400"></canvas>
        </div>
    </div>
</div>

