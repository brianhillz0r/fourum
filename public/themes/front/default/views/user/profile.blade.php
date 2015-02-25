<div class="row">
    <div class="col-md-2">
        <img src="{{ gravatar($user->getEmail(), 165) }}">
    </div>

    <div class="col-md-9">
        <h3>{{ $user->getUserName() }}</h3>
    </div>
</div>

<div class="row buffer">
    <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
            <li><a href="">Send Message</a></li>
        </ul>
    </div>
</div>
