{!! view('meta') !!}
{!! view('header') !!}

<div class="row">
    <div class="col-md-12">
        <h3>Groups</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        {!! view('groups.sidebar') !!}
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <h4>{{ $group->getName() }}</h4>
            </div>
        </div>

        <div class="row buffer-lg">
            <div class="col-md-12">
                {!! Form::open(array('url' => 'admin/groups/add-user', 'method' => 'post', 'role' => 'form', 'class' => 'form form-inline')) !!}

                    {!! Form::hidden('groupId', $group->getId()) !!}

                    <div class="form-group" style="width:93%">
                        {!! Form::text('username', Input::old('username'), array('class' => 'form-control', 'placeholder' => 'Username')) !!}
                    </div>

                    {!! Form::button('Add', array('class' => 'btn btn-default btn-primary', 'type' => 'submit')) !!}

                {!! Form::close() !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th>Member</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($group->getUsers() as $user)
                        <tr>
                            <td>
                                <a href="{{ url('admin/users/manage/' . $user->getId()) }}">
                                    {{ $user->getUsername() }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm pull-right">
                                    <a href="{{ url('admin/groups/remove/'. $group->getId() .'/' . $user->getId()) }}" class="btn btn-danger">Remove</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{!! view('footer') !!}
