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
                <nav class="nav-pills flex-column">
                    <div class="nav-item">
                        <a href="#" class="nav-link active">New Client</a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">Rejected Shipment</a>

                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">Not Available Consignee</a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">Consignee Rescheduled</a>
                    </div>
                </nav>
            </div>
            <div class="col-md-9">
                <style>
                    @media  only screen and (max-width: 600px) {
                        .inner-body {
                            width: 100% !important;
                        }

                        .footer {
                            width: 100% !important;
                        }
                    }

                    @media  only screen and (max-width: 500px) {
                        .button {
                            width: 100% !important;
                        }
                    }
                </style>
                <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;"><tr>
                        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                                <tr>
                                    <td class="header" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
                                        <a href="http://v2.kangaroo.test" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
                                            <img src="http://kangaroo-v2.test/images/logo-fullxhdpi.png" alt="Kangaroo Delivery" height="75" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; max-width: 100%; border: none;"></a>
                                    </td>
                                </tr>
                                <!-- Email Body --><tr>
                                    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                            <!-- Body content --><tr>
                                                <td class="content-cell" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                                    <h3 style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #2F3133; font-size: 14px; font-weight: bold; margin-top: 0; text-align: left;">Dear Triovari</h3>
                                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Thank you for registering on Kangaroo courier services, your user account details are :</p>
                                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;"><strong style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">Account Number:</strong> 10000</p>
                                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;"><strong style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">Username:</strong> Triovari</p>
                                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;"><strong style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">Password:</strong> kexi252</p>
                                                    <hr style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Your account is now active and you have access to our online services.
                                                        If you need any assistance, don't hesitate to contact us at : support@kangaroo-delivery.com.</p>

                                                    <table class="subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-top: 1px solid #EDEFF2; margin-top: 25px; padding-top: 25px;"><tr>
                                                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 12px;">Kind regards,<br>Kangaroo Delivery Operations</p>
                                                            </td>
                                                        </tr></table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;"><tr>
                                                <td class="content-cell" align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #AEAEAE; font-size: 12px; text-align: center;">© 2018 Kangaroo Delivery. All rights reserved.</p>
                                                </td>
                                            </tr></table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr></table>
            </div>
        </div>
    </div>
@endsection