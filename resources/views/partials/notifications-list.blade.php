<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Notifications</span>
        @if(auth()->user()->unreadNotifications()->count() > 0)
            <form method="POST" action="{{ $markAllRoute }}">
                @csrf
                <button class="btn btn-sm btn-primary" type="submit">Mark all as read</button>
            </form>
        @endif
    </div>

    <div class="card-body">
        @if($notifications->count())
            <div class="list-group">
                @foreach($notifications as $notification)
                    <a href="{{ $notification->data['url'] ?? '#' }}" class="list-group-item list-group-item-action {{ is_null($notification->read_at) ? 'list-group-item-light' : '' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $notification->data['title'] ?? 'Notification' }}</h6>
                            <small class="text-muted">{{ $notification->created_at->format('d-M-Y H:i A') }}</small>
                        </div>
                        <p class="mb-1">{{ $notification->data['message'] ?? '' }}</p>
                        @if(is_null($notification->read_at))
                            <small class="text-primary">Unread</small>
                        @else
                            <small class="text-muted">Read</small>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-muted">No notifications available.</div>
        @endif
    </div>
</div>
