<div class="row">
	<div class="col-md-6">
		<h3>{{{ $forum->title }}}</h3>
	</div>
	<div class="col-md-6">
		<p style="float:right;margin-top:12px;">
			<a href="{{ url('/thread/create/' . $forum->id) }}" class="btn btn-default btn-primary">New Thread</a>
		</p>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		@foreach ($forum->getThreads() as $thread)
		<h4>
			<a href="{{ $thread->getUrl() }}">{{ $thread->getTitle() }}</a>
		</h4>
		@endforeach
	</div>
</div>
