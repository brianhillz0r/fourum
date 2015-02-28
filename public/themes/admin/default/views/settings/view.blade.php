{!! view('meta') !!}
{!! view('header') !!}

<div class="row">
    <div class="col-md-12">
        <h3>Settings</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        {!! view('settings.sidebar', ['activeTab' => $activeTab]) !!}
    </div>
    <div class="col-md-9" style="height:1000px;">
        <h4 style="margin-bottom:20px;">{{ ucwords($namespace) }}</h4>
        {!! view('settings.form', ['settings' => $settings]) !!}
    </div>
</div>

{!! view('footer') !!}
