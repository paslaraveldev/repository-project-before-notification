@extends('layout.studentconstant')

@section('content')
<div class="container">
    <h2>Edit Proposal</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('proposals.modify', $proposal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="4" required>{{ old('description', $proposal->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="pdf" class="form-label">Proposal PDF</label>
            <input type="file" class="form-control" name="pdf" id="pdf" accept=".pdf">
            <small>Leave empty if you don't want to change the file.</small>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Supporting Image</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
            <small>Leave empty if you don't want to change the image.</small>
            @if($proposal->image_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $proposal->image_path) }}" alt="Proposal Image" class="img-thumbnail" width="150">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Proposal</button>
        <a href="{{ route('proposals.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
