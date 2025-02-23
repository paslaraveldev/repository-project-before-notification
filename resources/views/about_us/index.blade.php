@extends('layout.studentconstant')
@section('content')
<div class="container">
    <h1>About Us</h1>
    <a href="{{ route('about.create') }}" class="btn btn-primary">Add New</a>
    
    @if($about)
        <div>
            <h2>{{ $about->purpose }}</h2>
            <p><strong>Mission:</strong> {{ $about->mission }}</p>
            <p><strong>Vision:</strong> {{ $about->vision }}</p>
            <p><strong>Features:</strong> {{ $about->features }}</p>
            <p><strong>Audience:</strong> {{ $about->audience }}</p>
            <p><strong>Workflow:</strong> {{ $about->workflow }}</p>
            <p><strong>Policies:</strong> {{ $about->policies }}</p>
            <p><strong>Team:</strong> {{ $about->team }}</p>
            <p><strong>Contacts:</strong></p>
            <ul>
                <li>Phone 1: {{ $about->phone1 }}</li>
                <li>Phone 2: {{ $about->phone2 }}</li>
                <li>Phone 3: {{ $about->phone3 }}</li>
                <li>Phone 4: {{ $about->phone4 }}</li>
                <li>Email: {{ $about->email }}</li>
                <li>P.O. Box: {{ $about->po_box }}</li>
            </ul>
            <a href="{{ route('about.show', $about->id) }}" class="btn btn-info">View</a>
            <a href="{{ route('about.edit', $about->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('about.destroy', $about->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    @else
        <p>No About Us details found.</p>
    @endif
</div>
@endsection
