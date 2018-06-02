@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('zones') }}
@endsection

@section('pageTitle')
    @component('layouts.components.pageTitle')
        <i class='fas fa-map-marker-alt'></i> @lang("zone.label")
        @slot('actions')
            <div class="ml-auto d-flex px-2 align-items-center">
                <div class="btn-group" role="group">
                    <a href="{{ route('zones.create') }}" class="btn btn-secondary"><i
                                class="fa fa-plus-circle mr-2"></i> @lang('zone.new')</a>
                </div>
            </div>
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        @if($zones->count())
            @foreach($zones as $zone)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <h4 class="font-weight-bold m-0">{{ $zone->name }}</h4>
                                <div class="ml-auto d-flex">
                                    <a href="{{ route('zones.edit', ['zone'=>$zone->id]) }}"
                                       class="btn btn-light btn-sm" title="@lang('zone.edit')">
                                        <i class="fa fa-edit"></i></a>
                                    <form action="{{ route('zones.destroy', ['zone' => $zone->id]) }}"
                                          method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-light btn-sm" title="@lang('zone.delete')"
                                                type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <small>@lang('zone.standard_weight'): </small><b>{{ $zone->base_weight }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('zone.charge_per_unit'): </small><b>{{ $zone->charge_per_unit }}</b>
                            </li>
                            <li class="list-group-item">
                                <small>@lang('zone.extra_fees_per_unit'): </small><b>{{ $zone->extra_fees_per_unit }}</b>
                            </li>
                        </ul>
                        @if($zone->addresses->count())
                            <div class="card-footer btn" data-toggle="collapse" href="#zoneAddresses_{{ $zone->id }}"
                                 role="button"
                                 aria-expanded="false" aria-controls="zoneAddresses_{{ $zone->id }}">
                                @lang('zone.addresses') <i class="fa fa-angle-down ml-2"></i>
                            </div>
                            <ul class="collapse list-group list-group-flush" id="zoneAddresses_{{ $zone->id }}">
                                @foreach($zone->addresses as $address)
                                    <li class="list-group-item address-group-item">
                                        <span class="my-1">{{ $address->name }}</span>
                                        <div class="actions">
                                            <a class="btn btn-link btn-sm"
                                               href="{{ route('address.edit', ['zone' => $zone->id,'address' => $address->id]) }}"
                                               title="@lang('zone.address.edit')"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('address.destroy', ['zone' => $zone->id, 'address' => $address->id]) }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-link btn-sm" title="@lang('zone.address.delete')"
                                                        type="submit"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection