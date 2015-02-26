{!! view('meta') !!}
{!! view('header') !!}

<div class="row">
    <div class="col-md-12">
        <h3>Packages</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="2">Package</th>
                </tr>
            </thead>
            <tbody>
            @foreach($packages as $package)
                <tr>
                    <td>
                        <h4>{{ $package->package->getPackageName() }}</h4>
                        <p>{{ $package->package->getPackageDescription() }}</p>
                    </td>
                    <td width="200px">
                        @if($package->isEnabled)
                            <a href="{{ url('/admin/packages/disable/' . $package->packageClass) }}" class="btn btn-danger">Disable</a>
                        @else
                            <a href="{{ url('/admin/packages/enable/' . $package->packageClass) }}" class="btn btn-success">Enable</a>
                        @endif
                        <a href="" class="btn btn-info">Settings</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>

{!! view('footer') !!}