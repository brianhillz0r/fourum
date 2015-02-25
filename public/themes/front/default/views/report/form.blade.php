{!! Form::open(array('url' => '/report', 'method' => 'post', 'role' => 'form')) !!}

    {!! Form::hidden('id', $id) !!}
    {!! Form::hidden('type', $type) !!}

    <div class="form-group">
        {!! Form::label('message', 'Message') !!}
        {!! Form::textarea('message', Input::old('message'), array('class' => 'form-control')) !!}
    </div>

    {!! Form::button('Send', array('class' => 'btn btn-default btn-primary pull-right', 'type' => 'submit')) !!}

{!! Form::close() !!}
