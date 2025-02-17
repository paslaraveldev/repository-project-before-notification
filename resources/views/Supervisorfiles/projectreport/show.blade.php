@extends('layouts.supervisorconstant')

@section('content')
<div class="container">
    <h2>Report: {{ $report->title }}</h2>

    <p><strong>Status:</strong> {{ $report->status }}</p>
    <p><strong>Group:</strong> {{ $report->group->name }}</p>

    @if($report->uploaded_pdf)
        <p>
            <a href="{{ Storage::url($report->uploaded_pdf) }}" target="_blank" class="btn btn-primary">
                Download Student Report PDF
            </a>
        </p>
    @endif

    @if($report->review_pdf)
        <p>
            <a href="{{ route('supervisor.reports.downloadReviewPdf', $report->id) }}" class="btn btn-success">
                Download Review PDF
            </a>
        </p>
    @endif

    <h3>Supervisor Comments</h3>
    @if($report->comments->isEmpty())
        <p>No comments yet.</p>
    @else
        <ul class="list-group">
            @foreach($report->comments as $comment)
                <li class="list-group-item">
                    <strong>{{ $comment->supervisor->name }}:</strong> 
                    {{ $comment->comment }} 
                    <span class="text-muted">({{ $comment->created_at->format('d M Y, H:i') }})</span>
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Upload Review PDF Form -->
    <h4 class="mt-4">Upload Review PDF</h4>
    <form action="{{ route('supervisor.reports.uploadReviewPdf', $report->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="review_pdf" class="form-label">Upload Review PDF:</label>
            <input type="file" name="review_pdf" id="review_pdf" class="form-control" accept="application/pdf" required>
        </div>
        <button type="submit" class="btn btn-dark">Submit Review PDF</button>
    </form>

    <!-- Add Comment & Update Status Form -->
    <h4 class="mt-4">Add Comment & Update Status</h4>
    <form action="{{ route('supervisor.reports.review', $report->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="supervisor_comments" class="form-label">Add Comment:</label>
            <textarea name="supervisor_comments" id="supervisor_comments" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Change Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="Draft" {{ $report->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Ready for Submission" {{ $report->status == 'Ready for Submission' ? 'selected' : '' }}>Ready for Submission</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
</div>
@endsection
