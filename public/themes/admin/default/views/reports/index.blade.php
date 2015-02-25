{!! view('meta') !!}
{!! view('header') !!}

<div class="row">
    <div class="col-md-12">
        <h3>Reports</h3>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
                <th>ID</th>
                <th>Reporter</th>
                <th>Message</th>
                <th>Offender</th>
                <th>Reported</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->getId() }}</td>
                    <td>
                        <a href="{{ url('/admin/users/manage/' . $report->getUser()->getId()) }}">
                            {{ $report->getUser()->getUsername() }}
                        </a>
                    </td>
                    <td>{{ $report->getMessage() }}</td>
                    <td>
                        <a href="{{ url('/admin/users/manage/' . $report->getReportable()->getAuthor()->getId()) }}">
                            {{ $report->getReportable()->getAuthor()->getUsername() }}
                        </a>
                    </td>
                    <td>{{ $report->getCreatedAt() }}</td>
                    <td>
                        <div class="btn-group btn-group-sm pull-right">
                            <a href="{{ $report->getReportable()->getUrl() }}" target="_blank" class="btn btn-default">View</a>
                            <a href="{{ url('/admin/reports/mark-read/' . $report->getId()) }}" class="btn btn-default">Mark as Read</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{!! view('footer') !!}
