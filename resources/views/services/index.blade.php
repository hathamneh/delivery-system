@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('services') }}
@endsection

@section('pageTitle')
    <i class='fa-handshake2'></i> @lang("service.label")
@endsection

@section('actions')
    <a href="{{ route('services.create') }}" class="btn btn-primary"><i
                class="fa-plus-circle"></i> <span>@lang('service.create')</span>
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @if(session('alert'))
                <div class="col-12">
                    @component('bootstrap::alert', [
                        'type' => session('alert')->type ?? "primary",
                        'dismissible' => true,
                        'animate' => true,
                       ])
                        {{ session('alert')->msg }}
                    @endcomponent
                </div>
            @endif
            @foreach($services as $service)
                @php /** @var App\Service $service */ @endphp
                <div class="col-sm-3">
                    <div class="card service-card">
                        <div class="card-body">
                            <div class="service-name" title="@lang('service.name')">{{ $service->name }}</div>
                            <div class="service-price" title="@lang('service.price')"><small class="currency">@lang('common.jod')</small> {{ $service->price }}</div>
                        </div>
                        <div class="card-footer">
                            <div class="service-links">
                                @if($service->shipmentsCount())
                                <a href="#"
                                   class="service-shipments btn btn-sm btn-link">{{ trans_choice('shipment.shipments',$service->shipmentsCount(), ['value'=>$service->shipmentsCount()]) }}</a>
                                @else
                                    <span class="service-shipments btn btn-sm">{{ trans_choice('shipment.shipments',$service->shipmentsCount(), ['value'=>$service->shipmentsCount()]) }}</span>
                                @endif
                                <div class="btn-group">
                                    <a href="{{ route('services.edit', [$service]) }}"
                                       class="btn btn-sm btn-secondary"
                                       data-toggle="tooltip" title="@lang('service.edit')"><i class="fa-edit"></i></a>
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
        </div>
    </div>
@endsection
