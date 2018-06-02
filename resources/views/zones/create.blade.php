@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('zones.create') }}
@endsection

@section('pageTitle')
    @component('layouts.components.pageTitle')
        <i class='fas fa-map-marker-alt'></i> @lang("zone.new")
    @endcomponent
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-8 mx-auto">
            <form action="{{ route('zones.store') }}" class="create-zone-form" method="post">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="name">@lang('zone.name')</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="@lang('zone.name')">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="base_weight">@lang('zone.standard_weight')</label>
                        <input type="text" class="form-control" name="base_weight" id="base_weight"
                               placeholder="@lang('zone.standard_weight')">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="charge_per_unit">@lang('zone.charge_per_unit')</label>
                        <input type="text" class="form-control" name="charge_per_unit" id="charge_per_unit"
                               placeholder="@lang('zone.charge_per_unit')">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="extra_fees_per_unit">@lang('zone.extra_fees_per_unit')</label>
                        <input type="text" class="form-control" name="extra_fees_per_unit" id="extra_fees_per_unit"
                               placeholder="@lang('zone.extra_fees_per_unit')">
                    </div>
                </div>
                <div class="d-flex">
                    <button class="btn btn-primary ml-auto" type="submit"><i class="fa fa-save"></i> @lang('zone.save')
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection