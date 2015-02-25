<h3>Report a {{ ucwords($type) }}</h3>

<hr>

<p>
    You're reporting a <a href="{{ $subject->getUrl() }}">{{ $type }}</a> by {{ $subject->getAuthor()->getUsername() }}
</p>

<hr>

@include('report.form')
