@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments.create') }}
@endsection

@section('pageTitle')
    <i class='fa fa-archive'></i> @lang("shipment.new")
@endsection

@section('actions')
    <div class="ml-auto d-flex px-2 align-items-center">
        <div class="btn-group" role="group">
            <a href="{{ route('shipments.create', ['type' => 'wizard']) }}" class="btn btn-secondary"
               aria-pressed="false"><i class="fa fa-magic"></i> Wizard</a>
            <a href="#" class="btn btn-secondary active" aria-pressed="true"><i class="fa fa-bars"></i> Normal</a>
        </div>
    </div>
@endsection

@section('content')

    <div class="legacy-new-shipment">
        <div class="container px-0 px-sm-3">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <form role="form" action="{{ route('shipments.store') }}" method="post">
                        {{ csrf_field() }}
                        @include('shipments.wizard.clientInfo')
                        @include('shipments.wizard.details')
                        @include('shipments.wizard.delivery')

                        @component('bootstrap::modal',[
                                'id' => 'reviewShipmentModal',
                                'sizeClass' => 'modal-lg',
                            ])
                            @slot('title')
                                @lang('shipment.review')
                            @endslot
                            @include("shipments.review")
                            @slot('footer')
                                <button class="btn btn-light mr-auto" type="button" data-dismiss="modal">@lang('common.cancel')</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">@lang('shipment.edit')</button>
                                <button class="btn btn-primary" type="submit">@lang('shipment.save')</button>
                            @endslot
                        @endcomponent

                        <div class="d-flex mt-4">
                            <div class="ml-auto text-right">
                                <button class="btn btn-primary btn-lg" type="button" data-toggle="modal"
                                        data-target="#reviewShipmentModal">
                                    @lang('shipment.review')
                                </button>
                                <p class="form-text text-muted">
                                    @lang('shipment.reviewNote')
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
