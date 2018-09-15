@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('zones.edit', $zone) }}
@endsection

@section('pageTitle')
    <i class='fas fa-map-marker-alt'></i> @lang("zone.edit") {{ $zone->name }}
@endsection


@section('content')
    <div class="container">
        <div class="row">
            @if(session('alert'))
                <div class="col-md-8 mx-auto">
                    @component('bootstrap::alert', [
                        'type' => session('alert')->type ?? "primary",
                        'dismissible' => true,
                        'animate' => true,
                       ])
                        {!! session('alert')->msg  !!}
                    @endcomponent
                </div>
            @endif
            <div class="col-md-8 mx-auto">
                <form action="{{ route('zones.update', ['zone' => $zone->id]) }}" class="create-zone-form"
                      method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="name">@lang('zone.name')</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   value="{{ $zone->name ?? "" }}"
                                   placeholder="@lang('zone.name')">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="base_weight">@lang('zone.standard_weight')</label>
                            <input type="text" class="form-control" name="base_weight" id="base_weight"
                                   placeholder="@lang('zone.standard_weight')" value="{{ $zone->base_weight ?? "" }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="charge_per_unit">@lang('zone.charge_per_unit')</label>
                            <input type="text" class="form-control" name="charge_per_unit" id="charge_per_unit"
                                   placeholder="@lang('zone.charge_per_unit')"
                                   value="{{ $zone->charge_per_unit ?? "" }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="extra_fees_per_unit">@lang('zone.extra_fees_per_unit')</label>
                            <input type="text" class="form-control" name="extra_fees_per_unit" id="extra_fees_per_unit"
                                   placeholder="@lang('zone.extra_fees_per_unit')"
                                   value="{{ $zone->extra_fees_per_unit ?? "" }}">
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <button class="btn btn-info ml-2" type="submit"><i
                                    class="fa fa-save mr-2"></i> @lang('zone.save')
                        </button>
                        <a href="{{ route('zones.index') }}" class="btn btn-outline-info">@lang('zone.back')
                        </a>
                        <button class="btn btn-outline-danger mr-auto" data-toggle="modal" type="button"
                                data-target="#deleteZone-{{ $zone->id }}"><i
                                    class="fa-trash"></i> @lang('zone.delete')</button>

                    </div>
                </form>
                @component('layouts.components.deleteItem', [
                    'name' => 'zone',
                    'id' => $zone->id,
                    'action' => route('zones.destroy', [$zone])
                ])@endcomponent

                <hr><hr>

                @include('zones.addressesList')

            </div>
        </div>
    </div>

    @component('layouts.components.modal', [
                'modalId' => 'createAddressModal',
                'modalTitle' => 'Add New Address',
                ])
        @include('addresses.form')
    @endcomponent

@endsection

@section('beforeBody')
    <script src="{{ asset('js/ajaxRequests.js?1') }}"></script>
@endsection