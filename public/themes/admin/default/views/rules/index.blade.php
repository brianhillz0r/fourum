{!! view('meta') !!}
{!! view('header') !!}

<div class="row">
    <div class="col-md-12">
        <h3>Rules</h3>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @include('rules.form')
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if($rules)
        <br>
        <table class="table table-bordered table-striped">
            <thead>
                <th style="text-align:center">#</th>
                <th>Rule</th>
            </thead>
            <tbody>
                @foreach($rules as $key => $rule)
                <tr>
                    <td style="width:40px;text-align:center">{{ ++$key }}</td>
                    <td>{{ $rule->getRule() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{!! view('footer') !!}
