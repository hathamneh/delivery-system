@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('accounting') }}
@endsection

@section('pageTitle')
    <i class='fas fa-reports'></i> @lang("accounting.label")
@endsection

@section('content')
    <div class="container">
        <div class="card card-paper invoice">
            <div class="card-body">
                <table>
                    <tr>
                        <td class="invoice-logo"><img src="/images/logo-fullxhdpi.png" alt="Logo"></td>
                        <td class="invoice-top-meta">
                            <b>Date: </b> <span>{{ date("M d, Y") }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="table invoice-table table-bordered">
                                <thead>
                                <tr role="row" class="head-tr">
                                    <th class="">#</th>
                                    <th>HAWB</th>
                                    <th>Delivery Date</th>
                                    <th>Address</th>
                                    <th>Service Type</th>
                                    <th>Shipment Value</th>
                                    <th>Base Charge</th>
                                    <th>Extra fees</th>
                                    <th>Collected</th>
                                    <th>Net Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>70000</td>
                                    <td>07-04-2018</td>
                                    <td>الجاردنز</td>
                                    <td>Next Day</td>
                                    <td>200</td>
                                    <td>2.5</td>
                                    <td>0</td>
                                    <td>203</td>
                                    <td>2.85</td>
                                </tr>
                                <tr>
                                    <td colspan="11"></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection