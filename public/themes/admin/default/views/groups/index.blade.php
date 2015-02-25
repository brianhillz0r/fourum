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
        <div class="row buffer">
            <div class="col-md-12">
                <a href="<?= url('admin/groups/add') ?>" class="btn btn-default btn-primary" style="float:right;">
                    Add Group
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th>ID</th>
                        <th>Group Name</th>
                        <th>Members</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                        <tr>
                            <td>{{ $group->getId() }}</td>
                            <td>{{ $group->getName() }}</td>
                            <td>{{ count($group->getUsers()) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm pull-right">
                                    <a href="{{ url('admin/groups/view/' . $group->getId()) }}" class="btn btn-default">View / Add Members</a>
                                    <a href="{{ url('admin/groups/edit/' . $group->getId()) }}" class="btn btn-default">Edit</a>
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
