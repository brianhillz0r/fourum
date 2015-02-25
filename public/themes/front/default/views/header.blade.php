<div class="container">

    <div class="row">
        <div class="col-md-8">
            <h1><a href="{{ url('/') }}">{{ forum_name() }}</a></h1>
        </div>
        <div class="col-md-1">
            @if (auth()->check())
                <img src="{{ gravatar(user()->getEmail())  }}" style="margin-top:18px">
            @endif
        </div>
        <div class="col-md-3">
            @if (auth()->check())
            <h4 style="margin-top:20px;">{{ user()->getUsername() }}</h4>
            <div class="btn-group btn-group-sm post-controls">
                @foreach ($menuLoggedIn->getItems() as $item)

                    @if ($item->getTarget() == '/notifications')
                        <button type="button" id="notifications" class="btn btn-default btn-sm" data-container="body" data-toggle="popover" data-placement="bottom">
                            {{ ucwords($item->getName()) }}
                        </button>
                    @else
                        <a href="{{ $item->getTarget() }}" class="btn btn-default btn-sm">{{ ucwords($item->getName()) }}</a>
                    @endif

                @endforeach
            </div>
            @else
            <h4 style="margin-top:20px" class="pull-right"><a href="{{ url('register') }}">Create Account</a></h4>
            @endif
        </div>
    </div>

    @if (auth()->check())
    <div id="unread-notifications-title" class="hide">
        <div style="min-width: 175px;">
            Unread Notifications <a href="{{ url('/notifications/mark-read') }}"><i class="fa fa-check pull-right"></i></a>
        </div>
    </div>
    <div id="unread-notifications" class="hide">
        @foreach ($notifications as $notification)
        <p>
            {!! $notification->getDescription() !!}
        </p>
        @endforeach

        <hr class="buffer-sm">
        <p class="text-center buffer-sm"><a href="{{ url('/notifications') }}">View all</a></p>
    </div>
    @endif

<script type="text/javascript">
(function($, window, document) {

    $(function() {
        $('#notifications').popover({
            html: true,
            title: function() {
                return $('#unread-notifications-title').html();
            },
            content: function() {
                return $('#unread-notifications').html();
            }
        });
    });

}(window.jQuery, window, document));
</script>