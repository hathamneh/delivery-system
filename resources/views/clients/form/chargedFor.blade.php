@php /** @var App\Client $client */ @endphp
<h3 style="font-weight: bold;">Charged For</h3>
<div class="form-group">
    <div class="form-row">
        @foreach(['rejected', 'cancelled'] as $status)
        <div class="col-md-6">
            @component('clients.componenets.chargedForEdit', ['client'=>$client ?? null, 'status' => $status]) @endcomponent
        </div>
        @endforeach
    </div>

</div>