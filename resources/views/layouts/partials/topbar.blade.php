<!-- BEGIN TOPBAR -->
<div class="topbar">

    <div class="header-left">
        {{--if ($auth->getPerm() < 4) :--}}
        <div class="topnav">
            <a class="menutoggle" href="#" data-toggle="sidebar-collapsed"><span class="menu__handle"><span>Menu</span></span></a>
            <ul class="nav nav-icons">
                <li>
                    <a class="dashboard-btn" href="dashboard.php">
                        <span class="fa fa-home"></span>
                    </a>
                </li>

            </ul>

        </div>
        {{--endif;--}}
        <div class="welcome-msg">
            @lang("topbar.welcome")
        </div>
    </div>

    <div class="header-right">
        <ul class="header-menu nav navbar-nav">
        {{--if ($auth->getPerm() <= 3):--}}
        @include("layouts.partials.notifications")
        {{--endif;--}}
        <!-- BEGIN USER DROPDOWN -->
            <li class="dropdown" id="language-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-globe"></i>
                    <span>@lang('base.name')</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="?lang=ar" data-lang="ar"><img
                                    src="{{ asset('/images/flags/Jordan.png') }}"
                                    alt="flag-arabic">
                            <span>@lang('base.arabic')</span></a>
                    </li>
                    <li>
                        <a href="?lang=en" data-lang="en"><img
                                    src="{{ asset('/images/flags/usa.png') }}"
                                    alt="flag-english">
                            <span>@lang('base.english')</span></a>
                    </li>
                </ul>
            </li>
            <!-- END USER DROPDOWN -->

            <!-- BEGIN MESSAGES DROPDOWN -->
            <!-- END MESSAGES DROPDOWN -->
            <!-- BEGIN USER DROPDOWN -->
            <li class="logout-btn">
                <a href="/logout.php">
                    <i class="icon-power"></i><span class="hidden visible-lg">@lang("auth.logout")</span>
                </a>
            </li>
            <!-- END USER DROPDOWN -->
            <!-- CHAT BAR ICON -->
        </ul>
    </div>
    <!-- header-right -->
</div>
<!-- END TOPBAR -->