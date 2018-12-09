@if($services->count())
    @foreach($services as $service)
        @php /** @var App\Service $service */

            $custom = $service->customFor($client);
        @endphp
        <div class="col-sm-4 pb-3">
            <div class="card service-card {{ $custom ? "border-warning" : "" }}">
                <div class="card-body">
                    <div class="service-name" title="@lang('service.name')">{{ $service->name }}</div>
                    <div class="service-price" title="@lang('service.price')">
                        <small class="currency">@lang('common.jod')</small>
                        @if($custom)
                            <span class="text-dark mr-1">{{ fnumber($custom->pivot->price) }}</span>
                            <del><small>{{ fnumber($service->price) }}</small></del>
                        @else
                            {{ fnumber($service->price) }}
                        @endif
                    </div>

                </div>
                <div class="card-footer">
                    <div class="service-links">
                        @if($service->shipmentsCount())
                            <small
                               class="service-shipments p-1">{{ trans_choice('shipment.shipments',$service->shipmentsCount(), ['value'=>$service->shipmentsCount()]) }}</small>
                        @else
                            <small class="service-shipments p-1">{{ trans_choice('shipment.shipments',$service->shipmentsCount(), ['value'=>$service->shipmentsCount()]) }}</small>
                        @endif
                            <button class="btn btn-outline-warning" data-toggle="modal"
                                    data-target="#customizeService-{{ $service->id }}"><i class="fa-edit mr-2"></i> Customize</button>
                    </div>
                </div>
            </div>
        </div>

        @include('clients.services.customizeServiceModal')
    @endforeach
@else
    <div class="col-12">
        <p class="py-5 text-center text-muted">
            <i class="fa-exclamation-triangle mr-2"></i> No services yet!
        </p>
    </div>
@endif