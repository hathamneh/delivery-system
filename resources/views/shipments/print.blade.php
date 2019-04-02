@php /** @var \App\Shipment $shipment */ @endphp

@extends('layouts.print')

@section('content')
    <div class="container">

        <section class="shipments-print sheet ">
            <table class="w-100" cellpadding="6">
                <tr>
                    <td colspan="2" class="border-bottom">
                        <div class="d-flex justify-content-between p-3 align-items-center">

                            <div class="invoice-logo" style="flex: 1;">
                                <img src="/images/logo-fullxhdpi.png" alt="Logo" style="height: 60px;">
                            </div>
                            <div class="text-center" style="flex: 2;">
                                <h1>Shipment Details</h1>
                            </div>
                            <div style="flex: 1;">
                                <div class="text-right">
                                    <b>Date: </b> {{ now()->toFormattedDateString() }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table table-bordered">
                            <tr>
                                <th style="vertical-align: middle;">
                                    @lang('shipment.waybill'):
                                </th>
                                <td colspan="3"><b style="font-size: 1.25rem;">{{ $shipment->waybill }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="divider"><i class="fa-user-tie"></i> Client Info</td>
                            </tr>
                            @if($shipment->is_guest)
                                @include('shipments.print.client-guest')
                            @else
                                @include('shipments.print.client-registered')
                            @endif

                            <tr>
                                <td colspan="4" class="divider"><i class="fa-info-circle"></i> Delivery Details</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.delivery_date')
                                </th>
                                <td>
                                    {{ $shipment->delivery_date }}
                                </td>
                                <th>
                                    @lang('shipment.package_weight')
                                </th>
                                <td>{{ $shipment->package_weight }}</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.pieces')
                                </th>
                                <td>{{ $shipment->pieces }}</td>
                                <th>
                                    @lang('shipment.shipment_value')
                                </th>
                                <td>{{ $shipment->shipment_value }}</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.status')
                                </th>
                                <td>{{ $shipment->status->identifiableName() }}</td>
                                <th>
                                    @lang('shipment.custom_price')
                                </th>
                                <td>
                                    {{ is_null($shipment->total_price) ? trans('common.no') : (trans('common.yes') . ' ( '.$shipment->total_price .' )') }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.service_types.label')
                                </th>
                                <td>{{ trans('shipment.service_types.' . $shipment->service_type) }}</td>
                                <th>
                                </th>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.extra_services')
                                </th>
                                <td colspan="3">
                                    @include('shipments.print.services')
                                </td>
                            </tr>
                            <tr>
                                <td class="divider" colspan="4">
                                    <i class="fa-truck"></i> Consignee's information
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.consignee_name')
                                </th>
                                <td>{{ $shipment->consignee_name }}</td>
                                <th>
                                    @lang('shipment.phone_number')
                                </th>
                                <td>{{ $shipment->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('accounting.address')
                                </th>
                                <td>{{ $shipment->address->name }}</td>
                                <th>
                                    @lang('shipment.address_maps_link')
                                </th>
                                <td>{{ $shipment->address_maps_link }}</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.address_sub_text')
                                </th>
                                <td colspan="3">
                                    {{ $shipment->address_sub_text }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.courier')
                                </th>
                                <td>{{ optional($shipment->courier)->name }}</td>
                                <th>
                                    @lang('shipment.internal_notes')
                                </th>
                                <td>{{ $shipment->internal_notes }}</td>
                            </tr>
                            <tr>
                                <td class="divider" colspan="4">More</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.delivery_cost_lodger.label')
                                </th>
                                <td>{{ trans('shipment.delivery_cost_lodger.'.$shipment->delivery_cost_lodger) }}</td>
                                <th>
                                    @lang('shipment.reference')
                                </th>
                                <td>{{ $shipment->reference }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        @include('shipments.partials.conditions-of-carriage')
                    </td>
                </tr>

            </table>

        </section>
    </div>
@endsection