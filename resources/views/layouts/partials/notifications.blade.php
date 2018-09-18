<!-- BEGIN NOTIFICATION DROPDOWN -->
<li class="dropdown" id="notifications-header">
    <a href="#" class="dropdown-toggle" data-hover="dropdown" data-close-others="true"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon-bell"></i>
        <span class="badge badge-danger badge-header">{{ $notificationsCount }}</span>
    </a>
    <div class="dropdown-menu bg-transparent">
        <div class="list-group notofocations-list">
            @if($notifications->count())
                @foreach($notifications as $notification)
                    @php /** @var \Illuminate\Notifications\DatabaseNotification $notification */ @endphp
                    <div class="list-group-item list-group-item-action notification-item {{ ($notification->read() ?: "unread") }}">
                        <a href="{{ $notification->data['link'] }}">
                            <div>{{ $notification->data['message'] }}</div>
                            <small class="text-muted dropdown-time">{{ $notification->created_at }}</small>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="list-group-item notification-item">
                    <span class="text-muted">You have no notifications!</span>
                </div>
            @endif
        </div>
    </div>
</li>
<!-- END NOTIFICATION DROPDOWN -->