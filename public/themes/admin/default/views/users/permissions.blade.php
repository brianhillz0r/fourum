{!! Form::open(array('url' => 'admin/users/permissions/save', 'method' => 'post', 'role' => 'form')) !!}

    {!! Form::hidden('id', $user->getId()) !!}

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $name => $bool)
            <tr>
                <td>
                    {{ $name }}
                </td>
                <td class="text-center">
                    <label class="checkbox-inline">
                        @if($bool)
                        <input type="checkbox" name="{{ $name }}" checked="checked">
                        @else
                        <input type="checkbox" name="{{ $name }}">
                        @endif
                    </label>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {!! Form::button('Save', array('class' => 'btn btn-default btn-primary pull-right', 'type' => 'submit')) !!}

{!! Form::close() !!}
