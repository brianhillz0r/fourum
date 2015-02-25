<div class="row">
    <div class="col-md-6">
        <h3>{{ $thread->getTitle() }}</h3>
        <p>in <a href="{{ $forum->getUrl() }}">{{ $forum->getTitle() }}</a></p>
    </div>
    <div class="col-md-6">
        <p style="float:right;margin-top:12px;">
            <a href="{{ url('/post/create/' . $thread->id) }}" class="btn btn-default btn-primary">New Post</a>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @foreach($posts as $post)
        <div class="row post {{ $post->getId() == $highlight ? 'highlight' : '' }}" id="{{ $post->getId() }}">
            <div class="col-md-1">
                <img src="{{ gravatar($post->getAuthor()->getEmail()) }}">
                <h4>{{ $post->getAuthor()->getUsername() }}</h4>
            </div>
            <div class="col-md-11">
                <div class="row post-content-container">
                    <div class="col-md-12 post-content">
                        {!! $post->getContent() !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 post-meta">
                        @if ($post->isEdited())
                        <small>edited at {{ $post->getUpdatedAt() }}</small>
                        @endif

                        @if (auth()->check() && permissions()->can_administrate() && $post->getReportedCount() > 0)
                        <small>{{ $post->isEdited() ? ' - ' : '' }} reported {{ $post->getReportedCount() }} times</small>
                        @endif
                    </div>
                    <div class="col-md-8 col-skinny">
                        <div class="btn-group btn-group-sm post-controls">
                            @if ($post->getMenu() && $post->getMenu()->hasItems())
                                @foreach ($post->getMenu()->getItems() as $item)

                                    <a href="{{ $item->getTarget() }}" class="btn btn-default btn-sm">
                                        {{ ucwords($item->getName()) }}
                                    </a>

                                @endforeach
                            @endif
                            @if (auth()->check() && $post->isAuthor(user()))
                            <a href="javascript:;" data-inline-edit="{{ $post->getId() }}" class="btn btn-default">Edit</a>
                            @else
                            <a href="{{ url('/report/post/' . $post->getId()) }}" class="btn btn-default">Report</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{ $thread->getPosts()->render() }}
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @include('post.form', array('thread' => $thread))
    </div>
</div>
