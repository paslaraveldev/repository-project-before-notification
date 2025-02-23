@extends('layouts.supervisorconstant')

@section('content')
<div class="container">
    <h2>Supervisor Profile</h2>
    <p><strong>Name:</strong> {{ $supervisor->name }}</p>
    <p><strong>Email:</strong> {{ $supervisor->email }}</p>
    <p><strong>Job ID:</strong> {{ $supervisor->job_id_number }}</p>
    <p><strong>Department:</strong> {{ $supervisor->department->name ?? 'N/A' }}</p>
    <a href="{{ route('userprofile.edit') }}" class="btn btn-primary">Edit Profile</a>
</div>
@endsection
