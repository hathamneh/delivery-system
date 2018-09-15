@if($services->count())
    @foreach($services as $service)
        @php /** @var App\Service $service */ @endphp
        <div class="col-sm-4 pb-3">
            <div class="card service-card">
                <div class="card-body">
                    <div class="service-name" title="@lang('service.name')">{{ $service->name }}</div>
                    <div class="service-price" title="@lang('service.price')">
                        <small class="currency">@lang('common.jod')</small> {{ $service->price }}</div>
                </div>
                <div class="card-footer">
                    <div class="service-links">
                        @if($service->shipmentsCount())
                            <span
                               class="service-shipments btn btn-sm">{{ trans_choice('shipment.shipments',$service->shipmentsCount(), ['value'=>$service->shipmentsCount()]) }}</span>
                        @else
                            <span class="service-shipments btn btn-sm">{{ trans_choice('shipment.shipments',$service->shipmentsCount(), ['value'=>$service->shipmentsCount()]) }}</span>
                        @endif
                        <div class="btn-group">
                            <a href="{{ route('services.edit', [$service]) }}"
                               class="btn btn-sm btn-secondary"
                               data-toggle="tooltip" title="@lang('service.edit')"><i
                                        class="fa-edit"></i></a>
                            <a href="{{ route('services.edit', [$service]) }}"
                               class="btn btn-sm btn-danger"
                               data-toggle="tooltip" title="@lang('service.delete')"><i
                                        class="fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-12">
        <p class="py-5 text-center text-muted">
            <i class="fa-exclamation-triangle mr-2"></i> No services yet!
        </p>
    </div>
@endif