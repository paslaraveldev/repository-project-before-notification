@extends('layouts.adminconstant')

@section('content')
<div class="container">
    <h1>Approved Final Reports</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Group</th>
                <th>Supervisor</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
            <tr>
                <td>{{ $report->title }}</td>
                <td>{{ $report->group->name }}</td>
                <td>{{ $report->group->supervisor->name ?? 'N/A' }}</td>
                <td>{{ $report->status }}</td>
                <td>
                    <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-primary btn-sm">View</a>
                    <a href="{{ route('admin.reports.download', $report->id) }}" class="btn btn-success btn-sm">Download</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
