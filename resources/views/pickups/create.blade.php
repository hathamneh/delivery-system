@extends('layouts.pickups')


@section('breadcrumbs')
    {{ Breadcrumbs::render('pickups.create') }}
@endsection

@section('pageTitle')
    <i class='fa-shopping-bag'></i> @lang("pickup.new")
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <form action="{{ route('pickups.store') }}" method="post">
                {{ csrf_field() }}
                <div class="form-row">

                    <div class="form-group col-sm-12">
                        <label for="client_account_number">@lang('pickup.client_account_number')</label>
                        <select name="client_account_number" id="client_account_number"
                                class="form-control" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="waybills">@lang('pickup.waybills')</label>
                        <div>
                            <select name="waybills[]" id="waybills" class="select2-waybills form-control"
                                    multiple="multiple" data-tags="true">
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="available_time">@lang('pickup.available_time')</label>
                        <input type="text" name="available_time" id="available_time"
                               class="form-control datetime-rangepicker">
                    </div>

                    <div class="col-sm-12">
                        <hr>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="courier_id">@lang('pickup.courier')</label>
                        <select name="courier_id" id="courier_id" class="selectpicker form-control"
                                data-live-search="true" required>
                            <option {{ old('courier_id') ?: 'selected' }} disabled>@lang('common.select')</option>
                            @foreach($couriers as $courier)
                                <option {{ old('courier_id', -1) == $courier->id ?'selected' : '' }} value="{{ $courier->id }}"
                                        data-subtext="{{ $courier->user->username }}">{{ $courier->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="expected_packages_number">@lang('pickup.expected_packages_number')</label>
                        <input type="number" class="form-control" name="expected_packages_number"
                               id="expected_packages_number" placeholder="@lang('pickup.expected_packages_number')"
                               required>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="pickup_fees">@lang('pickup.pickup_fees')</label>
                        <input type="number" class="form-control" name="pickup_fees" step="0.1"
                               id="pickup_fees" placeholder="@lang('pickup.pickup_fees')">
                    </div>


                    <div class="col-sm-12 form-group">
                        <div class="card card-transparent">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="pickup_from">@lang('pickup.from')</label>
                                        <div>
                                            <div class="custom-control custom-radio mt-2 pb-2">
                                                <input type="radio" id="pickup_from_client" name="pickup_from"
                                                       class="custom-control-input" value="client">
                                                <label class="custom-control-label" for="pickup_from_client">
                                                    @lang('pickup.client')
                                                    <br>
                                                    <small class="text-muted">@lang('pickup.from_client_description')</small>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio mt-2 pt-2 mb-2 mb-sm-0">
                                                <input type="radio" id="pickup_from_customer" name="pickup_from"
                                                       value="customer" class="custom-control-input">
                                                <label class="custom-control-label" for="pickup_from_customer">
                                                    @lang('pickup.customer')
                                                    <br>
                                                    <small class="text-muted">@lang('pickup.from_client_description')</small>
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-row">
                                            <div class="col-sm-12 form-group">
                                                <label for="phone_number" class="d-none">@lang('pickup.phone')</label>
                                                <input type="text" name="phone_number" id="phone_number"
                                                       class="form-control" title="@lang('pickup.phone')" data-toggle="tooltip"
                                                       value="{{ old('phone_number') }}" data-placement="left"
                                                       placeholder="@lang('pickup.phone')">
                                            </div>
                                            <div class="col-sm-12 form-group">
                                                <label for="pickup_address_text"
                                                       class="d-none">@lang('pickup.address_text')</label>
                                                <input type="text" name="pickup_address.text" id="pickup_address_text"
                                                       class="form-control" title="@lang('pickup.address_text')" data-toggle="tooltip"
                                                       value="{{ old('pickup_address.text') }}" data-placement="left"
                                                       placeholder="@lang('pickup.address_text')">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="pickup_address_maps"
                                                       class="d-none">@lang('pickup.address_maps')</label>
                                                <input type="text" name="pickup_address.maps" id="pickup_address_maps"
                                                       class="form-control" title="@lang('pickup.address_maps')" data-toggle="tooltip"
                                                       value="{{ old('pickup_address.maps') }}" data-placement="left"
                                                       placeholder="@lang('pickup.address_maps')">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="notes_internal">@lang('pickup.notes')</label>
                        <textarea name="notes.internal" id="notes_internal" class="form-control"
                                  placeholder="@lang('pickup.notes')">{{ old('notes.internal') }}</textarea>
                    </div>

                    <div class="col-sm-12">
                        <hr>
                        <div class="d-flex">
                            <a href="{{ route('pickups.index') }}" class="btn btn-secondary">@lang('common.cancel')</a>
                            <button type="submit" class="btn btn-primary ml-auto"><i
                                        class="fa-save"></i> @lang('pickup.save')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('beforeBody')
    <script>
        var $clinetAccNum = $("#client_account_number");
        $clinetAccNum.select2({
            ajax: {
                url: '/api/suggest/clients',
                dataType: 'json',
                processResults: function (data, params) {
                    var out = {
                        results: data.data,
                    };
                    console.log(out);
                    return out;
                },
            },
            placeholder: "@lang('pickup.client_account_number')",
            minimumInputLength: 5,
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: function (data) {
                var markup = '<div class="client-suggestion">' +
                    '<b>' + data.name + '</b><br>' +
                    '<small>' + data.text + ' (' + data.trade_name + ')</small>' +
                    '</div>'
                return markup;
            }
        });
        $clinetAccNum.on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data)
            if(data.phone_number)
                $('#phone_number').val(data.phone_number);
            if(data.address_pickup_text)
                $('#pickup_address_text').val(data.address_pickup_text);
            if(data.address_pickup_maps)
                $('#pickup_address_maps').val(data.address_pickup_maps);
        });



        $('.select2-waybills').select2({
            tags: true,
            ajax: {
                url: '/api/suggest/shipments',
                processResults: function (data, params) {
                    console.log(data);
                    return data;
                },
            },
            placeholder: "@lang('pickup.waybills')",
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: function (data) {
                var markup = '<div class="shipment-suggestion">' +
                    '<b>' + data.text + '</b><br>';
                if (data.client || data.address || data.delivery_date) {
                    markup += "<small>";
                    markup += data.client ? "<span>Client: " + data.client + "</span> | " : "";
                    markup += data.client ? "<span>Address: " + data.address + "</span> | " : "";
                    markup += data.client ? "<span>Delivery Date: " + data.delivery_date + "</span>" : "";
                    markup += "</small>";
                }
                markup += '</div>';
                return markup;
            }
        });

    </script>
@endsection