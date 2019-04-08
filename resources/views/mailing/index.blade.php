@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('emails.index') }}
@endsection

@section('pageTitle')
    <i class='fas fa-envelope'></i> @lang("emails.label")
@endsection

@section('actions')
    @include('mailing.broadcast')
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

                    <a class="nav-link" id="mail5-pill" data-toggle="tab" href="#mail5" role="tab"
                       aria-controls="mail5" aria-selected="false">Failed Shipment</a>

                    <a class="nav-link" id="mail6-pill" data-toggle="tab" href="#mail6" role="tab"
                       aria-controls="mail6" aria-selected="false">Office Collection</a>

                    <a class="nav-link" id="mail7-pill" data-toggle="tab" href="#mail7" role="tab"
                       aria-controls="mail7" aria-selected="false">Invoice</a>

                </nav>
            </div>
            <div class="col-md-9">

                <div class="mailing-demo">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="mail1" role="tabpanel"
                             aria-labelledby="mail1-pill">
                            @component('mailing.demo-mail')
                                @markdown
                                @include("notifications.markdown.client-created")
                                @endmarkdown
                            @endcomponent
                        </div>
                        <div class="tab-pane fade" id="mail2" role="tabpanel" aria-labelledby="mail2-pill">
                            @component('mailing.demo-mail')
                                @markdown
                                @include("notifications.markdown.rejected-shipment")
                                @endmarkdown
                            @endcomponent
                        </div>
                        <div class="tab-pane fade" id="mail5" role="tabpanel" aria-labelledby="mail5-pill">
                            @component('mailing.demo-mail')
                                @markdown
                                @include("notifications.markdown.cancelled-shipment")
                                @endmarkdown
                            @endcomponent
                        </div>
                        <div class="tab-pane fade" id="mail3" role="tabpanel" aria-labelledby="mail3-pill">
                            @component('mailing.demo-mail')
                                @markdown
                                @include("notifications.markdown.not-available-consignee")
                                @endmarkdown
                            @endcomponent
                        </div>
                        <div class="tab-pane fade" id="mail4" role="tabpanel" aria-labelledby="mail4-pill">
                            @component('mailing.demo-mail')
                                @markdown
                                @include("notifications.markdown.consignee-rescheduled")
                                @endmarkdown
                            @endcomponent
                        </div>
                        <div class="tab-pane fade" id="mail5" role="tabpanel" aria-labelledby="mail5-pill">
                            @component('mailing.demo-mail')
                                @markdown
                                @include("notifications.markdown.failed-shipment")
                                @endmarkdown
                            @endcomponent
                        </div>
                        <div class="tab-pane fade" id="mail6" role="tabpanel" aria-labelledby="mail6-pill">
                            @component('mailing.demo-mail')
                                @markdown
                                @include("notifications.markdown.office-collection-shipment")
                                @endmarkdown
                            @endcomponent
                        </div>
                        <div class="tab-pane fade" id="mail7" role="tabpanel" aria-labelledby="mail7-pill">
                            @component('mailing.demo-mail2')
                                @markdown
                                @include("notifications.markdown.invoice")
                                @endmarkdown
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection