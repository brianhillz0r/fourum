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
                <h3>{{ $group->getName() }}</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#name" data-toggle="tab">Name</a></li>
                    <li><a href="#permissions" data-toggle="tab">Permissions</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 buffer">
                <div class="tab-content">
                    <div class="tab-pane active" id="name">
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(array('url' => 'admin/groups/edit', 'method' => 'post', 'role' => 'form')) !!}

                                    {!! Form::hidden('groupId', $group->getId()) !!}

                                    <div class="form-group">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', $group->getName(), array('class' => 'form-control')) !!}
                                    </div>

                                    {!! Form::button('Save', array('class' => 'btn btn-default btn-primary', 'type' => 'submit')) !!}

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="permissions">
                        {!! view('groups.permissions', array('group' => $group, 'permissions' => $permissions)) !!}
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

{!! view('footer') !!}
