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
                <h4>Add Group</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {!! view('groups.form') !!}
            </div>
        </div>
    </div>
</div>

{!! view('footer') !!}
