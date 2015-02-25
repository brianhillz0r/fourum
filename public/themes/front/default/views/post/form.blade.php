{!! Form::open(array('url' => 'post/create/' . $thread->id, 'method' => 'post', 'role' => 'form', 'id' => 'post-form')) !!}

    <div class="buffer-lg">
        {!! Form::textarea('content', null, array('id' => 'editor')) !!}
    </div>

    {!! Form::button('Post', array('class' => 'btn btn-default btn-primary pull-right', 'type' => 'submit')) !!}

{!! Form::close() !!}

<script>
(function($, window, document) {

    $(document).ready(function() {
        $('#editor').editable({
            inlineMode: false,
            inverseSkin: true
        });

        $('#post-form').keydown(function(e) {
            if (e.keyCode === 13 && e.metaKey) {
                $('#editor').editable("sync");
                $('#post-form').submit();
            }
        });
    });

}(window.jQuery, window, document));
</script>
