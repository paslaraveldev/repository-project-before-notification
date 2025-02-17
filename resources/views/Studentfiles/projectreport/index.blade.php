@extends('layout.studentconstant')

@section('content')
<div class="container">
    <h2>My Reports</h2>
    <div class="mb-3">
        <a href="{{ route('studentreports.create') }}" class="btn btn-primary">Create Report</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Submitted On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td>{{ $report->title }}</td>
                <td>{{ $report->status }}</td>
                <td>{{ $report->created_at }}</td>
                <td>
                    <a href="{{ route('studentreports.modify', $report->id) }}" class="btn btn-warning">Modify</a>
                    <a href="{{ route('student.reports.download', $report->id) }}" class="btn btn-primary">Download Report</a>
                    <a href="{{ route('student.reports.downloadSupervisorPdf', $report->id) }}" class="btn btn-info">Download Supervisor Review</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
