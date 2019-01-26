@extends('layouts.app')

@section('htmlHead')
    <style>
        .sf-sky .sf-wizard > form {
            padding: 0;
            border: none;
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
            @if ($errors->any())
                <div class="col-md-10 mx-auto">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="col-md-10 mx-auto">
                <div class="wizard-div current wizard-left">
                    <form novalidate class="shipment-form" data-style="sky" data-nav="top" role="form"
                          action="{{ route('shipments.store') }}"
                          method="post">
                        {{ csrf_field() }}
                        @include('shipments.wizard.clientInfo')
                        @include('shipments.wizard.delivery')
                        @include('shipments.wizard.details')
                        @include('shipments.review')
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('beforeBody')
    <script>
        $(document).ready(function () {
            $(".shipment-form").stepFormWizard({
                theme: "sky",
                height: 'auto',
            });
            $('#custom_price').on('change', function () {
                if($(this).is(':checked'))
                    $('#total_price').prop('disabled', false);
                else
                    $('#total_price').prop('disabled', true);
            });
        });
    </script>
@endsection