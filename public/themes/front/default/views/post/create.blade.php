<h3>New Post</h3>
<p>in <a href="{{ $thread->getUrl() }}">{{ $thread->getTitle() }}</a></p>

@foreach ($errors->all() as $error)
<div class="alert alert-danger">
    {{ $error }}
</div>
@endforeach

@include('post.form', array('thread' => $thread))
