@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('accounting') }}
@endsection

@section('pageTitle')
    <i class='fas fa-reports'></i> @lang("accounting.label")
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto mb-3">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="m-0 font-weight-bold">@lang('accounting.find_invoice')</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('accounting.goto') }}">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-sm-10">
                                    <input type="number" name="invoice_number" class="form-control {{ $errors->has('invoice_number') ? 'is-invalid' : '' }}"
                                           placeholder="@lang('accounting.invoice_no')">
                                    @if ($errors->has('invoice_number'))
                                        @foreach ($errors->get('invoice_number') as $message)
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-dark w-100">Go <i class="fa-play ml-1"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mx-auto">
                <form action="{{ route('accounting.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="card shadow">
                        <div class="card-header">
                            <h3 class="m-0 font-weight-bold">@lang('accounting.make_invoice')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-sm-12">
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-radio form-group">
                                                <input type="radio" id="type_client" name="type"
                                                       class="custom-control-input"
                                                       checked value="client">
                                                <label class="custom-control-label"
                                                       for="type_client">@lang('accounting.for_client')</label>
                                            </div>
                                            <div class="clients-group">
                                                @component('clients.search-client-input', [
                                                    'name' => "client_account_number",
                                                    'value' => old('for'),
                                                    'placeholder' => trans('accounting.client_account_number'),
                                                ]) @endcomponent
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-radio form-group">
                                                <input type="radio" id="type_courier" name="type"
                                                       class="custom-control-input"
                                                       value="courier">
                                                <label class="custom-control-label"
                                                       for="type_courier">@lang('accounting.for_courier')</label>
                                            </div>
                                            <div class="couriers-group">
                                                @component('couriers.search-courier-input',[
                                                    'name' => 'courier_id',
                                                    'placeholder' => trans('accounting.courier_name'),
                                                    'value' => old('for'),
                                                    'text' => "",
                                                    "disabled" => true
                                                ]) @endcomponent
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <label for="period" class="control-label">@lang('accounting.period')</label>
                                    <input type="text" name="period" id="period"
                                           value="{{ $invoice->period ?? old('period') }}"
                                           class="form-control date-rangepicker" data-ranges="true">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="discount" class="control-label">@lang('accounting.discount')</label>
                                    <input type="number" name="discount" id="discount" class="form-control" step="any"
                                           value="0.00">
                                    <small class="form-text text-muted">@lang('accounting.discount_note')</small>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer d-flex align-items-center">
                            <p class="m-0 text-muted">
                                Generated invoices will be saved to the system, so you can get back to them later.
                            </p>
                            <button class="btn btn-primary ml-auto">@lang('accounting.generate') <i
                                        class="ml-1 fa-play"></i></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
@endsection

@section('beforeBody')
    <script>
        $(document).ready(function () {
            $("input[name=type]").on('change', function () {
                var $couriers = $(".couriers-group"),
                    $clients = $('.clients-group'),
                    val = $(this).val();
                if (val === "client") {
                    // $couriers.hide();
                    // $clients.show();

                    $couriers.find('select').prop('disabled', true);
                    $clients.find('select').prop('disabled', false);
                } else if (val === 'courier') {
                    // $clients.hide();
                    // $couriers.show();

                    $clients.find('select').prop('disabled', true);
                    $couriers.find('select').prop('disabled', false);
                }
            })
        });
    </script>
@endsection