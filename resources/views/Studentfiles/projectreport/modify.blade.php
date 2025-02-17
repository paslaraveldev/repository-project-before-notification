@extends('layout.studentconstant')

@section('content')
<div class="container">
    <h2>Modify Report</h2>

    <form action="{{ route('studentreports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $report->title }}" required>
        </div>

        <div class="mb-3">
            <label for="abstract" class="form-label">Abstract</label>
            <textarea class="form-control" id="abstract" name="abstract" required>{{ $report->abstract }}</textarea>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (Optional)</label>
            <textarea class="form-control" id="description" name="description">{{ $report->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="video_link" class="form-label">Video Link (Optional)</label>
            <input type="url" class="form-control" id="video_link" name="video_link" value="{{ $report->video_link }}">
        </div>

        <div class="mb-3">
            <label for="pdf_file" class="form-label">Upload New PDF (Optional)</label>
            <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept="application/pdf">
            <p>Current File: <a href="{{ asset($report->pdf_file) }}" target="_blank">View PDF</a></p>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Upload New Image (Optional)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            @if ($report->image)
                <p>Current Image: <img src="{{ asset($report->image) }}" alt="Report Image" width="100"></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Report</button>
    </form>
</div>
@endsection