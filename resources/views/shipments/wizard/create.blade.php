@extends('layouts.app')

@section('htmlHead')
    <link href="/js/legacy/plugins/step-form-wizard/css/step-form-wizard.min.css" rel="stylesheet">
    <style>
        .sf-sky .sf-wizard > form {
            padding: 0;
        }

        .sf-step > fieldset {
            padding: 0 15px;
        }

        .sf-sky .sf-nav li {
            text-transform: none;
            text-align: left;
        }

        .sf-sky .sf-wizard .sf-btn, .sf-sky form .nocsript-sf-btn {
            margin-right: 15px;
        }
    </style>
    <script>
        var wizardFinishText = "{{ trans('shipment.review') }}";
    </script>
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments.create') }}
@endsection

@section('pageTitle')
    <i class='fa fa-archive'></i> @lang("shipment.new")
@endsection

@section('actions')
    <div class="ml-auto d-flex px-2 align-items-center">
        <div class="btn-group" role="group">
            <a href="#" class="btn btn-secondary active" aria-pressed="true"><i class="fa fa-magic"></i> Wizard</a>
            <a href="{{ route('shipments.create', ['type' => 'legacy']) }}" class="btn btn-secondary"
               aria-pressed="false"><i class="fa fa-bars"></i> Normal</a>
        </div>
    </div>
@endsection

@section('content')

    <div class="container px-0 px-sm-3">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="wizard-div current wizard-left">
                    <form class="wizard" data-style="sky" data-nav="top" role="form"
                          action="{{ route('shipments.store') }}"
                          method="post">
                        {{ csrf_field() }}
                        @include('shipments.wizard.clientInfo')
                        @include('shipments.wizard.details')
                        @include('shipments.wizard.delivery')
                        @include('shipments.review')
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('beforeBody')
    <script src="{{ asset('/js/legacy/plugins/step-form-wizard/plugins/parsley/parsley.min.js') }}"></script> <!-- OPTIONAL, IF YOU NEED VALIDATION -->
    <script src="{{ asset('/js/legacy/plugins/step-form-wizard/js/step-form-wizard.js') }}"></script> <!-- Step Form Validation -->
@endsection