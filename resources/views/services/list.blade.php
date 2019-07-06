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
                        @php $count = $service->shipmentsCount(); @endphp
                        @if($count)
                            <a href="{{ route('shipments.index', ['filters' => ['service' => $service->id]]) }}"
                               class="service-shipments btn btn-sm">
                                {{ trans_choice('shipment.shipments',$count, ['value'=>$count]) }}
                            </a>
                        @endif
                        <div class="btn-group">
                            <a href="{{ route('services.edit', [$service]) }}"
                               class="btn btn-sm btn-secondary"
                            data-toggle="tooltip" title="@lang('service.edit')"><i
                                        class="fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteService-{{ $service->id }}"
                                    data-toggle-tooltip title="@lang('service.delete')"><i
                                        class="fa-trash"></i></button>
                            @can('delete', $service)
                                @component('layouts.components.deleteItem', [
                                                    'name' => 'service',
                                                    'id' => $service->id,
                                                    'action' => route('services.destroy', [$service])
                                                ])@endcomponent
                            @endcan
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