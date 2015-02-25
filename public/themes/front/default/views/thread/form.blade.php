{!! Form::open(array('url' => 'thread/create/' . $forum->id, 'method' => 'post', 'id' => 'thread-form')) !!}

    <div class="form-group">
        <h3>New Thread</h3>
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', Input::old('title'), array('class' => 'form-control')) !!}
    </div>

    <div class="buffer-lg">
        {!! Form::textarea('content', null, array('id' => 'editor')) !!}
    </div>

    {!! Form::button('Save', array('class' => 'btn btn-default btn-primary', 'type' => 'submit')) !!}

{!! Form::close() !!}

<script type="text/javascript">
(function($, window, document) {

    $(document).ready(function() {
        $('#editor').editable({
            inlineMode: false,
            inverseSkin: true
        });
    });

}(window.jQuery, window, document));
</script>
