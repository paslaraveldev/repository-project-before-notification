@extends('layouts.adminconstant')

@section('content')
<div class="container">
    <h1>Approved Proposals</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Group</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proposals as $proposal)
            <tr>
                <td>{{ $proposal->title }}</td>
                <td>{{ $proposal->group->name ?? 'N/A' }}</td>
                <td>{{ $proposal->status }}</td>
                <td>
                    <a href="{{ route('admin.proposals.show', $proposal->id) }}" class="btn btn-primary btn-sm">View</a>
                    <a href="{{ route('admin.proposals.download', $proposal->id) }}" class="btn btn-success btn-sm">Download</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
