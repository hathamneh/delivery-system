<div class="row">
    <div class="col-md-3">
        @include('clients.zones.list')
    </div>
    <div class="col-md-9">
        @isset($selected)
            @include('clients.zones.selectedZone')
        @else
            <p class="p-5 text-center text-muted alert-dark">Select address from the list.</p>
        @endisset
    </div>
</div>