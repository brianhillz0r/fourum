{!! Form::open(array('url' => 'admin/groups/add', 'method' => 'post', 'role' => 'form')) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
    </div>

    {!! Form::button('Save', array('class' => 'btn btn-default btn-primary', 'type' => 'submit')) !!}

{!! Form::close() !!}
