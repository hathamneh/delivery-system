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
            @if(auth()->user()->isAuthorizedAny(["notes", "services", "zones"]))
                <li class="nav-parent{{ request()->is('notes*', 'services*', 'zones*', 'forms*') ? ' active' : '' }}">
                    <a href="#"><i
                                class="fas fa-rocket"></i><span>@lang('sidebar.extra')</span><span
                                class="fa fa-angle-down arrow"></span></a>
                    <ul class="children collapse">
                        @can('index', \App\Note::class)
                            <li class="{{ request()->is('notes*') ? 'active' : '' }}"><a
                                        href="{{ route('notes.index')  }}"><i
                                            class="fas fa-file"></i>@lang('note.label')</a></li>
                        @endcan
                        @can('index', \App\Zone::class)
                            <li class="{{ request()->is('zones*') ? ' active' : '' }}"><a
                                        href="{{ route('zones.index') }}"><i
                                            class="fas fa-map-marker-alt"></i><span>@lang('zone.label')</span></a></li>
                        @endcan
                        @can('index', \App\Service::class)
                            <li class="{{ request()->is('services*') ? ' active' : '' }}"><a
                                        href="{{ route('services.index') }}"><i
                                            class="fas fa-handshake2"></i><span>@lang('service.label')</span></a></li>
                        @endcan
                        @can('index', \App\Form::class)
                            <li class="{{ request()->is('forms*') ? ' active' : '' }}"><a
                                        href="{{ route('forms.index') }}"><i
                                            class="fas fa-file"></i><span>@lang('forms.label')</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endif
            @if(auth()->user()->isAuthorized("couriers"))
                <li class="nav-parent{{ request()->is('couriers*') ? ' active' : '' }}">
                    <a href="{{ route('couriers.index') }}"><i
                                class="fas fa-truck"></i><span>@lang('courier.label')</span><span
                                class="fa fa-angle-down arrow"></span></a>
                    <ul class="children collapse">
                        <li class="{{ (\Request::route()->getName() == 'couriers.index') ? 'active' : '' }}"><a
                                    href="{{ route('couriers.index') }}"><i
                                        class="fas fa-truck"></i>@lang('courier.all')</a></li>
                        @if(auth()->user()->isAuthorized("couriers", \App\Role::UT_CREATE))
                            <li class="{{ (\Request::route()->getName() == 'couriers.create') ? 'active' : '' }}"><a
                                        href="{{ route('couriers.create') }}"><i
                                            class="fas fa-plus-circle"></i>@lang('sidebar.add_new')</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(auth()->user()->isAuthorized("clients"))
                <li class="nav-parent{{ request()->is('clients*') ? ' active' : '' }}">
                    <a href="{{ route('clients.index') }}"><i
                                class="fa-user-tie"></i><span>@lang('client.label')</span><span
                                class="fa fa-angle-down arrow"></span></a>
                    <ul class="children collapse">
                        <li class="{{ (\Request::route()->getName() == 'clients.index') ? 'active' : '' }}"><a
                                    href="{{ route('clients.index') }}"><i
                                        class="fa-user-tie"></i>@lang('client.all')</a></li>
                        @if(auth()->user()->isAuthorized('clients', \App\Role::UT_CREATE))
                            <li class="{{ (\Request::route()->getName() == 'clients.create') ? 'active' : '' }}"><a
                                        href="{{ route('clients.create') }}"><i
                                            class="fas fa-plus-circle"></i>@lang('sidebar.add_new')</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(auth()->user()->isAuthorized("pickups"))
                <li class="nav-parent{{ request()->is('pickups*') ? ' active' : '' }}">
                    <a href="{{ route('pickups.index') }}"><i
                                class="fas fa-shopping-bag"></i><span>@lang('pickup.label')</span><span
                                class="fa fa-angle-down arrow"></span></a>
                    <ul class="children collapse">
                        @if(auth()->user()->isAdmin())
                            <li class="{{ (\Request::route()->getName() == 'pickups.index') && !request()->has('today') ? 'active' : '' }}"><a
                                        href="{{ route('pickups.index') }}"><i
                                            class="fas fa-shopping-bag"></i>
                                    {{ trans('pickup.all') }}
                                </a>
                            </li>
                        @endif
                        <li class="{{ (\Request::route()->getName() == 'pickups.index')  && request()->get('today') === "1" ? ' active' : '' }}">
                            <a
                                    href="{{ route('pickups.index', ['start' => now()->startOfDay()->timestamp, 'end' => now()->endOfDay()->timestamp, 'today' => true]) }}"><i
                                        class="fas fa-shopping-bag"></i>@lang('pickup.today_pickups')</a>
                        </li>

                        @if(auth()->user()->isAuthorized("pickups", \App\Role::UT_CREATE))
                            <li class=""><a href="{{ route('pickups.create') }}"><i
                                            class="fas fa-plus-circle"></i>@lang('sidebar.add_new')</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(auth()->user()->isAuthorized('shipments'))
                <li class="nav-parent{{ request()->is('shipments*') ? ' active' : '' }}">
                    <a href="{{ route('shipments.index') }}"><i
                                class="fas fa-shipment"></i><span>@lang('shipment.label')</span><span
                                class="fa fa-angle-down arrow"></span></a>
                    <ul class="children collapse">
                        <li class="{{ (\Request::route()->getName() == 'shipments.index') ? 'active' : '' }}"><a
                                    href="{{ route('shipments.index') }}"><i
                                        class="fas fa-shipment"></i>@lang('shipment.all')</a></li>
                        <li class="{{ request()->is('shipments?start='.now()->startOfDay()->timestamp.'&end='.now()->endOfDay()->timestamp) ? ' active' : '' }}">
                            <a
                                    href="{{ route('shipments.index', ['start' => now()->startOfDay()->timestamp, 'end' => now()->endOfDay()->timestamp, 'today' => true]) }}"><i
                                        class="fas fa-shipment"></i>@lang('shipment.today_shipments')</a>
                        </li>
                        <li class="{{ (\Request::is('shipments?scope=normal,guest')) ? 'active' : '' }}"><a
                                    href="{{ route('shipments.index', ['filters' => ['types' => 'normal,guest']]) }}"><i
                                        class="fas fa-shipment"></i>@lang('shipment.normal')</a></li>
                        <li class="{{ (\Request::is('shipments?scope=returned')) ? 'active' : '' }}"><a
                                    href="{{ route('shipments.index', ['filters' => ['types' => 'returned']]) }}"><i
                                        class="fas fa-shipment"></i>@lang('shipment.returned')</a></li>
                        @if(auth()->user()->isAuthorized('shipments', \App\Role::UT_CREATE))
                            <li class="{{ (\Request::route()->getName() == 'shipments.create') ? 'active' : '' }}"><a
                                        href="{{ route('shipments.create') }}"><i
                                            class="fas fa-plus-circle"></i>@lang('sidebar.add_new')</a></li>
                        @endif
                    </ul>
                </li>
            @endif


            @if(auth()->user()->isAdmin())
                <li class="nav-parent{{ request()->is('reports*', 'accounting*') ? ' active' : '' }}">
                    <a href="#"><i
                                class="fa-chart-bar"></i><span>@lang('sidebar.reporting')</span><span
                                class="fa fa-angle-down arrow"></span></a>
                    <ul class="children collapse">
                        <li class="{{ request()->is('reports*') ? 'active' : '' }}"><a
                                    href="{{ route('reports.index') }}"><i
                                        class="fa-reports"></i> @lang('reports.label')</a></li>
                        <li class="{{ request()->is('accounting*') ? 'active' : '' }}"><a
                                    href="{{ route('accounting.index') }}"><i
                                        class="fa-money-bill-alt2"></i> @lang('accounting.label')</a></li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->isAdmin())


                <li class="nav-parent{{ request()->is('users*', 'settings*', 'emails*') ? ' active' : '' }}">
                    <a href="/settings.php"><i
                                class="fas fa-wrench"></i><span>@lang('sidebar.manage')</span><span
                                class="fa fa-angle-down arrow"></span></a>
                    <ul class="children collapse">
                        <li class="{{ request()->is('users*') ? ' active' : '' }}"><a
                                    href="{{ route('users.index') }}"> <i
                                        class="fas fa-users"></i> @lang('sidebar.users_roles')</a></li>

                        <li class="{{ request()->is('emails*') ? ' active' : '' }}"><a
                                    href="{{ route('emails.index') }}">
                                <i class="far fa-envelope"></i> @lang('emails.label')</a></li>

                        <li class="{{ request()->is('settings*') ? 'active' : '' }}"><a
                                    href="{{ route('settings.index') }}"> <i
                                        class="fas fa-cogs"></i> @lang('sidebar.settings')</a></li>

                        {{--<li class=""><a href="/logs.php"> <i--}}
                        {{--class="fas fa-history"></i> @lang('sidebar.logs')</a></li>--}}
                    </ul>
                </li>
            @endif
        </ul>


        <div class="sidebar-footer clearfix">

            <a class="pull-left toggle_fullscreen" href="#" data-rel="tooltip" data-placement="top"
               data-original-title="Fullscreen">
                <i class="icon-size-fullscreen"></i></a>

            <a href="#" class="pull-left btn-effect" data-toggle="modal"
               data-target="#logoutModal"
                    {{ trans('common.dir') === "rtl" ? 'style="float: left !important;"' : 'style="float: right !important;"' }}>
                <span data-toggle="tooltip" title="@lang("auth.logout")"><i class="icon-power"></i></span></a>
        </div>
    </div>
</div>
<!-- END SIDEBAR -->
<?php /*endif;*/ ?>
