@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('accounting') }}
@endsection

@section('pageTitle')
    <i class='fas fa-reports'></i> @lang("accounting.label")
@endsection

@section('actions')
    <button class="btn btn-secondary" data-toggle="modal"
            data-target="#newInvoiceModal"><i class="fa-plus-circle"></i> @lang('accounting.make_invoice')</button>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 mx-auto">
                <form action="{{ route('accounting.goto') }}">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col-auto d-flex align-items-center"><label
                                    for="invoice_number">@lang('accounting.find_invoice')</label></div>
                        <div class="col">
                            <input type="number" name="invoice_number" id="invoice_number"
                                   class="form-control {{ $errors->has('invoice_number') ? 'is-invalid' : '' }}"
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
        <div class="invoices-table">
            <h3>@lang('accounting.invoices')</h3>
            <div class="table-responsive">
                <table class="table dataTable table-hover">
                    <thead>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Period</th>
                        <th>For</th>
                        <th>Created At</th>
                        <th>Marked as Paid At</th>
                        <th>Admin Marked as Paid</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $invoice)
                        @php /** @var App\Invoice $invoice */ @endphp
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->period }}</td>
                            <td>
                                <span class="badge badge-secondary mr-2 text-capitalize">{{ $invoice->type }}</span>
                                @if($invoice->target instanceof \App\Client)
                                    {{ $invoice->target->trade_name }} (Account
                                    No.: {{ $invoice->target->account_number }})
                                @elseif($invoice->target instanceof \App\Courier)
                                    {{ $invoice->target->name }}
                                @elseif($invoice->target instanceof \App\Guest)
                                    {{ $invoice->target->name }} (Nat. ID: {{ $invoice->target->national_id }})
                                @endif
                            </td>
                            <td>{{ $invoice->created_at }}</td>
                            <td>{{ $invoice->decision_date ?? "Not Paid" }}</td>
                            <td>{{ $invoice->decisionBy ? $invoice->decisionBy->username : "" }}</td>
                            <td><a href="{{ route('accounting.invoice', [$invoice]) }}"
                                   class="btn btn-outline-secondary">View</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="newInvoiceButton"
             id="newInvoiceModal" aria-hidden="true">
            <form action="{{ route('accounting.store') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('accounting.make_invoice')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">


                            @if($errors->count() && $errors->has('national_id'))

                                <div class="alert alert-danger">
                                    {{ $errors->get('national_id')[0] }}
                                </div>
                            @endif
                            <div class="form-row">
                                <div class="form-group col-sm-12">
                                    <div class="form-row">
                                        <div class="col-sm-4">
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
                                        <div class="col-sm-4">
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
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-radio form-group">
                                                <input type="radio" id="type_national_id" name="type"
                                                       class="custom-control-input"
                                                       value="national_id">
                                                <label class="custom-control-label"
                                                       for="type_national_id">@lang('client.national_id')</label>
                                            </div>
                                            <div class="a-group">
                                                <input type="text" name="national_id" id="national_id" disabled
                                                       class="form-control"
                                                       placeholder="@lang('client.national_id')">
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
                                    <label for="discount"
                                           class="control-label">@lang('accounting.discount')</label>
                                    <input type="number" name="discount" id="discount" class="form-control"
                                           step="any"
                                           value="0.00">
                                    <small class="form-text text-muted">@lang('accounting.discount_note')</small>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex align-items-center">
                            <p class="m-0 text-muted">
                                Generated invoices will be saved to the system, so you can get back to them
                                later.
                            </p>
                            <button class="btn btn-primary ml-auto">@lang('accounting.generate') <i
                                        class="ml-1 fa-play"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection

@section('beforeBody')
    <script>
        $(document).ready(function () {
            $("input[name=type]").on('change', function () {
                var $couriers = $(".couriers-group"),
                    $clients = $('.clients-group'),
                    $nationalId = $('.a-group'),
                    val = $(this).val();
                if (val === "client") {
                    $couriers.find('select').prop('disabled', true);
                    $nationalId.find('input').prop('disabled', true);
                    $clients.find('select').prop('disabled', false).focus();
                } else if (val === 'courier') {
                    $clients.find('select').prop('disabled', true);
                    $nationalId.find('input').prop('disabled', true);
                    $couriers.find('select').prop('disabled', false).focus();
                } else if (val === 'national_id') {
                    $clients.find('select').prop('disabled', true);
                    $couriers.find('select').prop('disabled', true);
                    $nationalId.find('input').prop('disabled', false).focus();
                }
            })
        });
    </script>
@endsection