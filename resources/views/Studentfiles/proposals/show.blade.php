@extends('layout.studentconstant')

@section('content')
<div class="container">
    <h2 class="mb-4">Proposal Details</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $proposal->title }}</h4>
            <p><strong>Description:</strong> {{ $proposal->description }}</p>
            <p><strong>Status:</strong> {{ $proposal->status }}</p>
            <p><strong>Group Members:</strong></p>
            <ul>
                @foreach($proposal->group->students as $student)
                    <li>{{ $student->name }} Email  {{ $student->email }}</li>
                @endforeach
            </ul>

            <a href="{{ route('proposals.download', $proposal->id) }}" class="btn btn-primary">Download Proposal</a>
        </div>
    </div>
</div>
@endsection
