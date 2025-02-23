@extends('layout.studentconstant')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">My Reports</h2>

    <div class="mb-3">
        <a href="{{ route('studentreports.create') }}" class="btn btn-primary">Create Report</a>
    </div>

    @if($reports->isEmpty())
        <div class="alert alert-warning">You have not submitted any reports yet.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
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
                    <td>
                        <span class="badge {{ $report->status == 'Draft' ? 'bg-warning' : 'bg-success' }}">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td>{{ $report->created_at->format('d M Y, H:i A') }}</td>
                    <td>
                        <a href="{{ route('studentreports.modify', $report->id) }}" class="btn btn-warning btn-sm">Modify</a>
                        <a href="{{ route('student.reports.download', $report->id) }}" class="btn btn-primary btn-sm">Download Report</a>
                        @if($report->review_pdf)
                            <a href="{{ route('student.reports.downloadReviewPdf', $report->id) }}" class="btn btn-success btn-sm">Download Review PDF</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection