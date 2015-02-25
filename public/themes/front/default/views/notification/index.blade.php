<h3>Notifications</h3>

<hr>

@foreach ($notifications as $notification)

@if (! $notification->isRead())
    <h4>
        {!! $notification->getDescription() !!}
        <span style="color:#ccc">{{ $notification->getTimestamp()->diffForHumans() }}</span>
    </h4>
@else
    <p>
        {!! $notification->getDescription() !!}
        <span style="color:#ccc">{{ $notification->getTimestamp()->diffForHumans() }}</span>
    </p>
@endif

@endforeach
