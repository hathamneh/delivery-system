@if($services->count())
    @foreach($services as $service)
        @php /** @var App\Service $service */

            $custom = $service->customFor($client);
        @endphp
        <div class="col-sm-4 pb-3">
            <div class="card service-card {{ $custom ? "border-warning" : "" }}">
                <div class="card-body">
                    <button class="btn btn-outline-warning w-100 mb-2" data-toggle="modal"
                            data-target="#customizeService-{{ $service->id }}"><i class="fa-edit mr-2"></i> Customize</button>
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
                            <a href="#"
                               class="service-shipments btn btn-sm btn-link">{{ trans_choice('shipment.shipments',$service->shipmentsCount(), ['value'=>$service->shipmentsCount()]) }}</a>
                        @else
                            <span class="service-shipments btn btn-sm">{{ trans_choice('shipment.shipments',$service->shipmentsCount(), ['value'=>$service->shipmentsCount()]) }}</span>
                        @endif
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