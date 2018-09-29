<!-- BEGIN TOPBAR -->
<div class="topbar">

    <div class="header-left">
        {{--if ($auth->getPerm() < 4) :--}}
        <div class="topnav">
            <a class="menutoggle" href="#" data-toggle-sidebar="sidebar-collapsed"><span class="menu__handle"><span>Menu</span></span></a>
            <ul class="nav nav-icons">
                <li>
                    <a class="dashboard-btn" href="{{ route('home') }}">
                        <span class="fa fa-home"></span>
                    </a>
                </li>

            </ul>

        </div>
        {{--endif;--}}
        <div class="welcome-msg">
            @lang("topbar.welcome", ["name" => $displayName])
        </div>
    </div>

    <div class="header-right d-none d-md-block">
        <ul class="header-menu nav navbar-nav">
            {{--<li id="nav-search">--}}
                {{--<a id="search-results" href="#"><i class="icon-magnifier"></i></a>--}}
            {{--</li>--}}
        {{--if ($auth->getPerm() <= 3):--}}
        @include("layouts.partials.notifications")
        {{--endif;--}}
        <!-- BEGIN USER DROPDOWN -->
            <li class="dropdown" id="language-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-globe"></i>
                    <span>@lang('common.name')</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="?lang=ar" data-lang="ar"><img
                                    src="{{ asset('/images/flags/Jordan.png') }}"
                                    alt="flag-arabic">
                            <span>@lang('common.arabic')</span></a>
                    </li>
                    <li>
                        <a href="?lang=en" data-lang="en"><img
                                    src="{{ asset('/images/flags/usa.png') }}"
                                    alt="flag-english">
                            <span>@lang('common.english')</span></a>
                    </li>
                </ul>
            </li>
            <!-- END USER DROPDOWN -->

            <!-- BEGIN MESSAGES DROPDOWN -->
            <!-- END MESSAGES DROPDOWN -->
            <!-- BEGIN USER DROPDOWN -->
            <li class="logout-btn">
                <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="icon-power"></i><span class="d-none d-md-inline-block">@lang("auth.logout")</span>
                </a>
            </li>
            <!-- END USER DROPDOWN -->
            {{--<li id="quickview-toggle"><a href="#"><i class="icon-bubbles"></i></a></li>--}}

        </ul>
    </div>
    <!-- header-right -->
</div>
<!-- END TOPBAR -->