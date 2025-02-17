@extends('layouts.adminconstant')

@section('content')
<div class="container">
    <h1>{{ $proposal->title }}</h1>
    <p><strong>Group:</strong> {{ $proposal->group->name ?? 'N/A' }}</p>
    <p><strong>Description:</strong> {{ $proposal->description }}</p>
    <p><strong>Status:</strong> {{ $proposal->status }}</p>

    <a href="{{ route('admin.proposals.download', $proposal->id) }}" class="btn btn-success">Download Proposal</a>
    <a href="{{ route('admin.proposals.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
