{!! Form::open(array('url' => 'auth/login', 'method' => 'post', 'role' => 'form')) !!}

    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Password') !!}
        {!! Form::password('password', array('class' => 'form-control')) !!}
    </div>

    {!! Form::button('Login', array('type' => 'submit', 'class' => 'btn btn-default btn-primary')) !!}

{!! Form::close() !!}
