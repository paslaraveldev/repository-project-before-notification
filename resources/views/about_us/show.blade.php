@extends('layout.studentconstant')

@section('content')
<div class="container">
    <h1>About Us Details</h1>
    <p><strong>Purpose:</strong> {{ $about->purpose }}</p>
    <p><strong>Mission:</strong> {{ $about->mission }}</p>
    <p><strong>Vision:</strong> {{ $about->vision }}</p>
    <p><strong>Features:</strong> {{ $about->features }}</p>
    <p><strong>Audience:</strong> {{ $about->audience }}</p>
    <p><strong>Workflow:</strong> {{ $about->workflow }}</p>
    <p><strong>Policies:</strong> {{ $about->policies }}</p>
    <p><strong>Team:</strong> {{ $about->team }}</p>
    <p><strong>Phone 1:</strong> {{ $about->phone1 }}</p>
    <p><strong>Phone 2:</strong> {{ $about->phone2 }}</p>
    <p><strong>Phone 3:</strong> {{ $about->phone3 }}</p>
    <p><strong>Phone 4:</strong> {{ $about->phone4 }}</p>
    <p><strong>Email:</strong> {{ $about->email }}</p>
    <p><strong>PO Box:</strong> {{ $about->po_box }}</p>
    
    <a href="{{ route('about.index') }}">Back</a>
</div>
@endsection
