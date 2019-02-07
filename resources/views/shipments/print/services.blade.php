@if($shipment->services->count())
    <li><b>@lang('accounting.extra_services'):</b>
        @foreach($shipment->services as $service)
            @php /** @var \App\Service $service */ @endphp
            <span class="invoice__service-item">({{ $service->name }}
                                                    , @if ($custom_service = $service->customFor($client))
                    {{ fnumber($custom_service->pivot->price) }}
                @else {{ fnumber($service->price) }} @endif
                                                    )</span>
        @endforeach
    </li>
@endif