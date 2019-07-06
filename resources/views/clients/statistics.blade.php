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
