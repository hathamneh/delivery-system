@extends('layouts.pickups')


@section('breadcrumbs')
    {{ Breadcrumbs::render('pickups.edit', $pickup->id) }}
@endsection

@section('pageTitle')
    <i class='fa-shopping-bag'></i> @lang("pickup.edit")
@endsection

@section('actionsFirst')
    <a href="{{ route('pickups.index') }}" class="btn btn-light">
        <i class="fa-shopping-bag"></i> <span>@lang('pickup.all')</span>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <form action="{{ route('pickups.update', ['pickup' => $pickup->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                @include('pickups.form')
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
                var markup = data.text;
                if (data.name && data.trade_name)
                    markup = '<div class="client-suggestion">' +
                        '<b>' + data.name + '</b><br>' +
                        '<small>' + data.text + ' (' + data.trade_name + ')</small>' +
                        '</div>'
                return markup;
            }
        });
        $clinetAccNum.on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data)
            if (data.phone_number)
                $('#phone_number').val(data.phone_number);
            if (data.address_pickup_text)
                $('#pickup_address_text').val(data.address_pickup_text);
            if (data.address_pickup_maps)
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