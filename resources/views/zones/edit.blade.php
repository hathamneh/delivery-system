@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('zones.edit', $zone->id) }}
@endsection

@section('pageTitle')
    <i class='fas fa-map-marker-alt'></i> @lang("zone.edit")
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
                        {{ session('alert')->msg }}
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
                    <div class="d-flex">
                        <button class="btn btn-primary ml-auto" type="submit"><i
                                    class="fa fa-save mr-2"></i> @lang('zone.save')
                        </button>
                    </div>
                </form>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="d-flex mb-1">
                                    <h3 class="font-weight-bold m-0">@lang('zone.addresses')</h3>
                                    <a href="{{ route('address.create', ['zone'=>$zone->id]) }}"
                                       data-target="#createAddressModal"
                                       data-toggle="modal" class="btn btn-sm btn-secondary ml-auto"><i
                                                class="fa fa-plus-circle mr-2"></i> @lang('zone.address.new')</a>
                                </div>
                                <table class="table table-hover addresses-table">
                                    <thead>
                                    <tr>
                                        <th>@lang('zone.address.name')</th>
                                        <th>@lang('zone.address.sameday_price')</th>
                                        <th>@lang('zone.address.scheduled_price')</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($zone->addresses->count())
                                        @foreach($zone->addresses as $address)
                                            <tr>
                                                <td>{{ $address->name }}</td>
                                                <td>{{ $address->sameday_price }}</td>
                                                <td>{{ $address->scheduled_price }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a class="btn btn-link btn-sm"
                                                           href="{{ route('address.edit', ['zone' => $zone->id,'address' => $address->id]) }}"
                                                           title="@lang('zone.address.edit')"><i class="fa fa-edit"></i></a>
                                                        <form action="{{ route('address.destroy', ['zone' => $zone->id, 'address' => $address->id]) }}"
                                                              method="post">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button class="btn btn-link btn-sm"
                                                                    title="@lang('zone.address.delete')"
                                                                    type="submit"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @php unset($address) @endphp
                                    @else
                                        <tr class="empty-row">
                                            <td colspan="5">
                                                <small class="text-center text-muted p-3 d-block">
                                                    <i class="fa fa-info-circle"></i> @lang('zone.no_addresses')
                                                </small>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @component('layouts.components.modal', [
                'modalId' => 'createAddressModal',
                'modalTitle' => 'Add New Address',
                ])
        @include('addresses.form', ['ajax'=>true])
    @endcomponent

@endsection

@section('beforeBody')
    <script src="{{ asset('js/ajaxRequests.js?1') }}"></script>
@endsection