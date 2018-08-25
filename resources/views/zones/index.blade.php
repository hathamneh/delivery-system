@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('zones') }}
@endsection

@section('pageTitle')
    <i class='fas fa-map-marker-alt'></i> @lang("zone.label")
@endsection

@section('actions')
    <div class="ml-auto d-flex px-2 align-items-center">
        <div class="btn-group" role="group">
            <a href="{{ route('zones.create') }}" class="btn btn-secondary"><i
                        class="fa fa-plus-circle mr-2"></i> @lang('zone.new')</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @if($zones->count())
                @foreach($zones as $zone)
                    <div class="col-md-12 zone-column border-secondary">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="zone-card mb-md-0 mb-1">
                                    <h4 class="font-weight-bold text-center">{{ $zone->name }}</h4>
                                    <div class="zone-info">
                                        <div>
                                            <b>{{ $zone->base_weight }}</b>
                                            <small>@lang('zone.standard_weight')</small>
                                        </div>
                                        <div>
                                            <b>{{ $zone->charge_per_unit }}</b>
                                            <small>@lang('zone.charge_per_unit')</small>
                                        </div>
                                        <div>
                                            <b>{{ $zone->extra_fees_per_unit }}</b>
                                            <small>@lang('zone.extra_fees_per_unit')</small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($zone->addresses->count())
                                    <div class="card zone-addresses-list"
                                         aria-expanded="false" aria-controls="zoneAddresses_{{ $zone->id }}">
                                        <div class="card-header"><b>{{ $zone->name }}</b> @lang('zone.addresses2')</div>
                                        <ul class="list-group list-group-flush"
                                            id="zoneAddresses_{{ $zone->id }}">
                                            @foreach($zone->addresses as $address)
                                                <li class="list-group-item address-group-item">
                                                    <div>{{ $address->name }}</div>
                                                    <div class="actions">
                                                        <a class="btn btn-link btn-sm"
                                                           href="{{ route('address.edit', ['zone' => $zone->id,'address' => $address->id]) }}"
                                                           title="@lang('zone.address.edit')"><i class="fa fa-edit"></i></a>
                                                        <button class="btn btn-link btn-sm"
                                                                title="@lang('zone.address.delete')"
                                                                type="button"
                                                                onclick="$('deleteAddress-{{ $address->id }}').submit()">
                                                            <i class="fa fa-trash"></i></button>
                                                    </div>
                                                    <form action="{{ route('address.destroy', ['zone' => $zone->id, 'address' => $address->id]) }}"
                                                          method="post" id="deleteAddress-{{ $address->id }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-2 ml-auto">
                                <div class="d-flex flex-md-column align-items-center justify-content-center h-100 mt-1">
                                    <a href="{{ route('zones.edit', ['zone'=>$zone->id]) }}"
                                       class="btn btn-light mb-md-1 mr-md-0 mr-1" title="@lang('zone.edit')">
                                        <i class="fa fa-edit"></i> @lang('zone.edit')</a>
                                    <button class="btn btn-light" title="@lang('zone.delete')"
                                            onclick="$('deleteZone-{{ $zone->id }}').submit()"
                                            type="button"><i
                                                class="fa fa-trash"></i> @lang('zone.delete')
                                    </button>
                                </div>
                                <form action="{{ route('zones.destroy', ['zone' => $zone->id]) }}"
                                      method="post" id="deleteZone-{{ $zone->id }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection