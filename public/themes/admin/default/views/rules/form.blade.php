{!! Form::open(array('url' => 'admin/rules/add', 'method' => 'post', 'role' => 'form', 'class' => 'form form-inline')) !!}

    <div class="form-group" style="width:94%">
        {!! Form::text('rule', Input::old('rule'), array('class' => 'form-control', 'placeholder' => 'Rule')) !!}
    </div>

    {!! Form::button('Save', array('class' => 'btn btn-default btn-primary', 'type' => 'submit')) !!}

{!! Form::close() !!}
