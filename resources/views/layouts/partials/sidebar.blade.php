<?php /*if ($auth->getPerm() <= 3) :*/ ?>
<!-- BEGIN SIDEBAR -->
<div class="sidebar">
    <div class="logopanel">
        <h1 style="background-image: url({{ asset('/images/logo-sm-white.png') }});"></h1>
    </div>
    <div class="sidebar-inner">
        <ul class="nav nav-sidebar" style="margin-top: 15px">

            <li class="{{ (\Request::route()->getName() == 'home') ? ' active' : '' }}">
                <a href="{{ route('home') }}"><i
                            class="fas fa-desktop"></i><span>@lang("sidebar.dashboard")</span></a>
            </li>
            <li class="nav-parent{{ request()->is('shipments*') ? ' active' : '' }}">
                <a href="{{ route('shipments.index') }}"><i
                            class="fas fa-shipment"></i><span>@lang('shipment.label')</span><span
                            class="fa fa-angle-down arrow"></span></a>
                <ul class="children collapse">
                    <li class="{{ (\Request::route()->getName() == 'shipments.index') ? 'active' : '' }}"><a
                                href="{{ route('shipments.index') }}"><i
                                    class="fas fa-shipment"></i>@lang('shipment.all')</a></li>
                    <li class="{{ (\Request::route()->getName() == 'shipments.create') ? 'active' : '' }}"><a
                                href="{{ route('shipments.create') }}"><i
                                    class="fas fa-plus-circle"></i>@lang('sidebar.add_new')</a></li>
                </ul>
            </li>
            <li class="nav-parent{{ request()->is('clients*') ? ' active' : '' }}">
                <a href="{{ route('clients.index') }}"><i
                            class="fa-user-tie"></i><span>@lang('client.label')</span><span
                            class="fa fa-angle-down arrow"></span></a>
                <ul class="children collapse">
                    <li class="{{ (\Request::route()->getName() == 'clients.index') ? 'active' : '' }}"><a
                                href="{{ route('clients.index') }}"><i
                                    class="fa-user-tie"></i>@lang('client.all')</a></li>
                    <li class="{{ (\Request::route()->getName() == 'clients.create') ? 'active' : '' }}"><a
                                href="{{ route('clients.create') }}"><i
                                    class="fas fa-plus-circle"></i>@lang('sidebar.add_new')</a></li>
                </ul>
            </li>
            <li class="nav-parent{{ request()->is('couriers*') ? ' active' : '' }}">
                <a href="{{ route('couriers.index') }}"><i
                            class="fas fa-truck"></i><span>@lang('courier.label')</span><span
                            class="fa fa-angle-down arrow"></span></a>
                <ul class="children collapse">
                    <li class="{{ (\Request::route()->getName() == 'couriers.index') ? 'active' : '' }}"><a
                                href="{{ route('couriers.index') }}"><i
                                    class="fas fa-truck"></i>@lang('courier.all')</a></li>
                    <li class="{{ (\Request::route()->getName() == 'couriers.create') ? 'active' : '' }}"><a
                                href="{{ route('couriers.create') }}"><i
                                    class="fas fa-plus-circle"></i>@lang('sidebar.add_new')</a></li>
                </ul>
            </li>
            <li class="nav-parent ">
                <a href="{{ route('pickups.index') }}"><i
                            class="fas fa-shopping-bag"></i><span>@lang('pickup.label')</span><span
                            class="fa fa-angle-down arrow"></span></a>
                <ul class="children collapse">
                    <li class=""><a href="{{ route('pickups.index') }}"><i
                                    class="fas fa-shopping-bag"></i>@lang('pickup.all')</a></li>
                    <li class=""><a href="{{ route('pickups.index', ['filter'=>'today']) }}"><i
                                    class="fas fa-shopping-bag"></i>@lang('pickup.today_pickups')</a></li>
                    <li class=""><a href="{{ route('pickups.create') }}"><i
                                    class="fas fa-plus-circle"></i>@lang('sidebar.add_new')</a></li>
                </ul>
            </li>
            <li class="nav-parent ">
                <a href="/pickups.php"><i
                            class="fas fa-file"></i><span>@lang('note.label')</span><span
                            class="fa fa-angle-down arrow"></span></a>
                <ul class="children collapse">
                    <li class=""><a href="/notes.php"><i
                                    class="fas fa-file"></i>@lang('note.public_notes')</a></li>
                    <li class=""><a href="/PrivateNotes.php"><i
                                    class="fas fa-lock"></i>@lang('note.private_notes')</a></li>

                </ul>
            </li>

            <?php /*if ($auth->getPerm() === 1) : */?>
            <li class="{{ request()->is('zones*') ? ' active' : '' }}"><a href="{{ route('zones.index') }}"><i
                            class="fas fa-map-marker-alt"></i><span>@lang('zone.label')</span></a></li>
            <li class=""><a href="/services.php"><i
                            class="fas fa-handshake2"></i><span>@lang('service.label')</span></a></li>
            <li class="nav-parent{{ request()->is('users*') ? ' active' : '' }}">
                <a href="{{ route('users.index') }}"><i
                            class="fas fa-users"></i><span>@lang('user.label')</span><span
                            class="fa fa-angle-down arrow"></span></a>
                <ul class="children collapse">
                    <li class="{{ (\Request::route()->getName() == 'users.index') ? ' active' : '' }}"><a
                                href="{{ route('users.index') }}"> <i
                                    class="fas fa-users"></i> @lang('user.all')</a></li>

                    <li class=""><a href="{{ route('roles.index') }}">
                            <i class="far fa-user-secret"></i> @lang('user.roles.label')</a></li>

                </ul>
            </li>
            <li class="nav-parent ">
                <a href="/settings.php"><i
                            class="fas fa-wrench"></i><span>@lang('sidebar.manage')</span><span
                            class="fa fa-angle-down arrow"></span></a>
                <ul class="children collapse">
                    <li class=""><a href="/settings.php"> <i
                                    class="fas fa-cogs"></i> @lang('sidebar.settings')</a></li>

                    <li class=""><a href="/mailing_settings.php">
                            <i class="far fa-envelope"></i> @lang('mailing.label')</a></li>

                    <li class=""><a href="/logs.php"> <i
                                    class="fas fa-history"></i> @lang('sidebar.logs')</a></li>
                </ul>
            </li>
            <?php /*endif;*/ ?>
        </ul>


        <div class="sidebar-footer clearfix">

            <a class="pull-left toggle_fullscreen" href="#" data-rel="tooltip" data-placement="top"
               data-original-title="Fullscreen">
                <i class="icon-size-fullscreen"></i></a>

            <a class="pull-left btn-effect" href="/logout.php" data-modal="modal-1" data-rel="tooltip"
               {{ trans('common.dir') === "rtl" ? 'style="float: left !important;"' : 'style="float: right !important;"' }}
               data-placement="top" data-original-title="@lang("auth.logout")">
                <i class="icon-power"></i></a>
        </div>
    </div>
</div>
<!-- END SIDEBAR -->
<?php /*endif;*/ ?>
