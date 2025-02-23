@extends('layout.studentconstant')
@section('content')
<div class="container">
    <h1>Edit About Us</h1>
    <form action="{{ route('about.update', $about->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Purpose</label>
            <input type="text" name="purpose" class="form-control" value="{{ $about->purpose }}" required>
        </div>
        <div class="form-group">
            <label>Mission</label>
            <input type="text" name="mission" class="form-control" value="{{ $about->mission }}" required>
        </div>
        <div class="form-group">
            <label>Vision</label>
            <input type="text" name="vision" class="form-control" value="{{ $about->vision }}" required>
        </div>
        <div class="form-group">
            <label>Features</label>
            <textarea name="features" class="form-control" required>{{ $about->features }}</textarea>
        </div>
        <div class="form-group">
            <label>Audience</label>
            <textarea name="audience" class="form-control" required>{{ $about->audience }}</textarea>
        </div>
        <div class="form-group">
            <label>Workflow</label>
            <textarea name="workflow" class="form-control" required>{{ $about->workflow }}</textarea>
        </div>
        <div class="form-group">
            <label>Policies</label>
            <textarea name="policies" class="form-control" required>{{ $about->policies }}</textarea>
        </div>
        <div class="form-group">
            <label>Team</label>
            <textarea name="team" class="form-control" required>{{ $about->team }}</textarea>
        </div>
        <div class="form-group">
            <label>Phone 1</label>
            <input type="text" name="phone1" class="form-control" value="{{ $about->phone1 }}" required>
        </div>
        <div class="form-group">
            <label>Phone 2</label>
            <input type="text" name="phone2" class="form-control" value="{{ $about->phone2 }}">
        </div>
        <div class="form-group">
            <label>Phone 3</label>
            <input type="text" name="phone3" class="form-control" value="{{ $about->phone3 }}">
        </div>
        <div class="form-group">
            <label>Phone 4</label>
            <input type="text" name="phone4" class="form-control" value="{{ $about->phone4 }}">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $about->email }}" required>
        </div>
        <div class="form-group">
            <label>P.O. Box</label>
            <input type="text" name="po_box" class="form-control" value="{{ $about->po_box }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
