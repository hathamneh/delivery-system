<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kangaroo Delivery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ mix('css/main.bundle.css') }}" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body class="{{ __("base.dir") }} sidebar-condensed account separate-inputs" data-page="login">
<!-- BEGIN LOGIN BOX -->
<div class="container" id="login-block">
    <div class="row align-items-center my-sm-0 my-5" style="min-height: 100vh;">
        <div class="col-sm-6 col-md-5">
            <div class="account-wall card card-light">
                <div class="text-center" style="margin-bottom: 20px;">
                    <h1 class="login-logo"></h1>
                    <hr>
                </div>

                <?php /*if (isset($zombie) && $zombie) : ?>
                <div class="alert alert-danger">
                    <?php __e("ZOMBIE_CREDENTIALS") ?>
                </div>
                <?php endif; ?>
                <?php if (isset($failure) && $failure) : ?>
                <div class="alert alert-danger">
                    <?php __e("WRONG_CREDENTIALS") ?>
                </div>
                <?php endif; */?>
                <form class="form-signin" role="form" action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    @if(!empty($errors->first()))

                        <div class="alert alert-danger">
                            <span>{{ $errors->first() }}</span>
                        </div>

                    @endif
                    <div class="append-icon">
                        <input type="text" name="username" id="name" class="form-control form-white username"
                               placeholder="{{ __('auth.username') }}" autofocus required>
                        <i class="icon-user"></i>
                    </div>
                    <div class="append-icon m-b-20">
                        <input type="password" name="password" class="form-control form-white password"
                               placeholder="{{ __('auth.password') }}" autocomplete="off" required>
                        <i class="icon-lock"></i>
                    </div>

                    <button type="submit" id="submit-form" class="btn btn-lg btn-primary btn-block ladda-button"
                            data-style="expand-left">Sign In
                    </button>
                    <div class="clearfix"></div>
                    <p class="pull-left"><a href="login.php?lang=en">English</a> | <a
                                href="login.php?lang=ar">العربية</a></p>
                </form>
            </div>
        </div>
        <div class="col-sm-6 col-md-7">
            <form action="#" class="form-shipment-status" id="form-shipment-status" method="post">
                <div class="row form-group">
                    <label for="identifier" class="col-md-12 control-label">
                        <b>@lang("shipment.track_shipment")</b>
                    </label>
                    <div class="col-md-12 input-btn-group">
                        <input type="text" class="form-control form-control-lg from-white" name="identifier"
                               id="identifier"
                               placeholder="@lang("shipment.enter_identifier")" required>
                        <button type="submit" class="btn btn-primary btn-block ladda-button g-recaptcha"
                                data-style="zoom-in"
                                data-sitekey="6LeHGUoUAAAAAHsB_fkTvSrLWkdlgwJRiffKn2po"
                                data-callback="shipmentStatusSubmit"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="clearfix"></div>
                    <small style="margin: 5px; font-size: 0.75rem; text-align: center; display: block;width: 100%;">@lang("base.recaptcha_policy_statement")</small>

                    <div class="col-md-12 status-result">

                    </div>
                </div>
            </form>
        </div>
    </div>
    <p class="account-copyright" style=" position:fixed;bottom:0;">
        <span>Kangaroo Delivery &copy; 2018 </span>
    </p>

</div>


<script src="{{ asset("/js/legacy/plugins/jquery/jquery.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/jquery/jquery-migrate-3.0.0.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/bootstrap/js/bootstrap.min.js") }}"></script>
<!--<script src="/assets/global/plugins/jquery-validation/jquery.validate.min.js"></script>
-->
<script src="{{ asset("/js/legacy/plugins/backstretch/backstretch.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/bootstrap-loading/dist/spin.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/bootstrap-loading/dist/ladda.min.js") }}"></script>
<script src="{{ asset("/js/legacy/globals/fontawesome-all.min.js") }}"></script>
<script>
    var redirect_to = "<?= $redirect ?? "dashboard.php" ?>";
</script>
<script src="{{ asset("/js/legacy/globals/pages/login-v1.js") }}"></script>


</body>
</html>