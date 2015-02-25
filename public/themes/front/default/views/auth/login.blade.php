<h2>Login</h2>

@if (Session::get('message'))
    <div class="alert alert-danger">
        {{ Session::get('message') }}
    </div>
@endif

@include('auth.login.form')
