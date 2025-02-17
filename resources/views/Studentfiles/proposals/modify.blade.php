@extends('layout.studentconstant')

@section('content')
<div class="container">
    <h2>Modify Proposal</h2>

   <form action="{{ route('proposals.modify', $proposal->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Laravel will interpret this as a PUT request -->

    <div class="mb-3">
        <label for="description" class="form-label">Proposal Description</label>
        <textarea name="description" class="form-control" rows="5" required>{{ old('description', $proposal->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="pdf" class="form-label">Upload New PDF (Optional)</label>
        <input type="file" name="pdf" class="form-control" accept="application/pdf">
        <small class="text-muted">Leave empty if you don't want to change the file.</small>
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="{{ route('proposals.index') }}" class="btn btn-secondary">Cancel</a>
</form>

</div>
@endsection
