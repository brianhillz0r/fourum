{!! Form::open(array('url' => 'admin/users/save', 'method' => 'post', 'role' => 'form')) !!}

    {!! Form::hidden('id', $user->getId()) !!}

    <div class="form-group">
        {!! Form::label('username', 'Username') !!}
        {!! Form::text('username', $user->getUserName(), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', $user->getEmail(), array('class' => 'form-control')) !!}
    </div>

    {!! Form::button('Save', array('class' => 'btn btn-default btn-primary pull-right', 'type' => 'submit')) !!}

{!! Form::close() !!}
