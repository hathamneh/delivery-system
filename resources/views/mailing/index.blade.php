@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('emails.index') }}
@endsection

@section('pageTitle')
    <i class='fas fa-envelope'></i> @lang("emails.label")
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 px-4">
                <h3 class="border-bottom mt-0 pb-2">Your Email templates</h3>
                <nav class="nav nav-pills flex-column" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="mail1-pill" data-toggle="tab" href="#mail1" role="tab"
                       aria-controls="mail1" aria-selected="true">New Client</a>

                    <a class="nav-link" id="mail2-pill" data-toggle="tab" href="#mail2" role="tab"
                       aria-controls="mail2" aria-selected="false">Rejected Shipment</a>

                    <a class="nav-link" id="mail5-pill" data-toggle="tab" href="#mail5" role="tab"
                       aria-controls="mail5" aria-selected="false">Cancelled Shipment</a>

                    <a class="nav-link" id="mail3-pill" data-toggle="tab" href="#mail3" role="tab"
                       aria-controls="mail3" aria-selected="false">Not Available Consignee</a>

                    <a class="nav-link" id="mail4-pill" data-toggle="tab" href="#mail4" role="tab"
                       aria-controls="mail4" aria-selected="false">Consignee Rescheduled</a>

                </nav>
            </div>
            <div class="col-md-9">

                <div class="mailing-demo">
                    @component('mailing.demo-mail')
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="mail1" role="tabpanel"
                                 aria-labelledby="mail1-pill">
                                @markdown
                                @include("notifications.markdown.client-created")
                                @endmarkdown
                            </div>
                            <div class="tab-pane fade" id="mail2" role="tabpanel" aria-labelledby="mail2-pill">
                                @markdown
                                @include("notifications.markdown.rejected-shipment")
                                @endmarkdown
                            </div>
                            <div class="tab-pane fade" id="mail5" role="tabpanel" aria-labelledby="mail5-pill">
                                @markdown
                                @include("notifications.markdown.cancelled-shipment")
                                @endmarkdown
                            </div>
                            <div class="tab-pane fade" id="mail3" role="tabpanel" aria-labelledby="mail3-pill">
                                @markdown
                                @include("notifications.markdown.not-available-consignee")
                                @endmarkdown
                            </div>
                            <div class="tab-pane fade" id="mail4" role="tabpanel" aria-labelledby="mail4-pill">
                                @markdown
                                @include("notifications.markdown.consignee-rescheduled")
                                @endmarkdown
                            </div>
                        </div>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection