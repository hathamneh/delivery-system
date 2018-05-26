<!-- BEGIN NOTIFICATION DROPDOWN -->
<li class="dropdown" id="notifications-header">
    <a href="#" class="dropdown-toggle" data-hover="dropdown" data-close-others="true"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon-bell"></i>
        <span class="badge badge-danger badge-header">5</span>
    </a>
    <ul class="dropdown-menu">
        <li class="dropdown-header clearfix">
            <p class="pull-left">5 @lang("Pending_Notifications")</p>
        </li>
        <li>
            <ul class="dropdown-menu-list withScroll" data-height="220">

                {{--foreach ($alerts as $alert) :--}}
                    <li class="notification-item unread">
                        <a href="$alert->url + &read= + $alert->id">
                            <i class="fa fa-flag p-r-10 f-18"></i>
                            Alert Type
                            <span class="dropdown-time">{{ date("d-m-Y h:i A") }}</span>
                            <span class="clearfix"></span>

                        </a>
                    </li>
                {{--endforeach;--}}
            </ul>
        </li>
        <li class="dropdown-footer clearfix">
            <a href="/alerts.php" class="pull-left"><?= __("SHOW_ALL_NOTIFICATION") ?></a>

        </li>
    </ul>
</li>
<!-- END NOTIFICATION DROPDOWN -->