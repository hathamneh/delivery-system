@php /** @var App\Client $client */ @endphp

<div class="form-group col-sm-12">
    <div class="row">
        @foreach(['rejected', 'cancelled'] as $status)
        <div class="col-md-6">
            @component('clients.componenets.chargedForEdit', ['client'=>$client ?? null, 'status' => $status]) @endcomponent
        </div>
        @endforeach
    </div>

</div>