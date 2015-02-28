<h4>Currently Applied Effects</h4>
<hr>

@foreach($currentEffects as $currentEffect)
    <div class="row">
        <div class="col-md-7">
            <h4>{{ $currentEffect->effect->getName() }}</h4>
            <p>{{ $currentEffect->effect->getDescription() }}</p>
        </div>
        <div class="col-md-5">
            <p><strong>Expires:</strong> {{ $currentEffect->effectModel->expires->diffForHumans() }}</p>
            <a href="" class="btn btn-danger pull-right">Remove</a>
        </div>
    </div>
    <hr>
@endforeach

<h4>Available Effects</h4>
<hr>
@foreach($availableEffects as $effect)
    <div class="row">
        <div class="col-md-7">
            <h4>{{ $effect->getName() }}</h4>
            <p>{{ $effect->getDescription() }}</p>
        </div>
        <div class="col-md-5">
            {!! form()->open(['url' => '/admin/users/apply-effect', 'method' => 'post', 'role' => 'form', 'class' => 'form-inline']) !!}
            {!! form()->hidden('user_id', $user->getId()) !!}
            {!! form()->hidden('effect', $effect->getInternalName()) !!}
            <div class="form-group">
                {!! form()->select('length', [
                'permanent' => 'Permanent',
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                ], 1, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! form()->select('unit', [
                'permanent' => 'Permanent',
                'hours' => 'Hours',
                'days' => 'Days',
                'weeks' => 'Weeks',
                'months' => 'Months',
                'years' => 'Years',
                ], 'hours', ['class' => 'form-control']) !!}
            </div>
            {!! form()->button('Apply', ['class' => 'btn btn-primary pull-right', 'type' => 'submit']) !!}
            {!! form()->close() !!}
        </div>
    </div>
    <hr>
@endforeach