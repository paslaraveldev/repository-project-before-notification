@extends('layout.studentconstant')

@section('content')
<div class="container">
    <h2>{{ $group->name ?? 'No Group Assigned' }} - Submitted Proposals</h2>

    <div class="mb-3">
        <a href="{{ route('proposals.create') }}" class="btn btn-success">Create Proposal</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($proposals->isEmpty())
        <p>No proposals submitted yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Submitted By</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proposals as $proposal)
                    <tr>
                        <td>{{ $proposal->title }}</td>
                        <td>{{ $proposal->submittedBy->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $proposal->status == 'Submitted' ? 'warning' : ($proposal->status == 'Approved' ? 'success' : 'danger') }}">
                                {{ $proposal->status }}
                            </span>
                        </td>
                        <td>

                          
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#commentsModal{{ $proposal->id }}">
                                View Comments ({{ $proposal->comments->count() }})
                            </button>

                             <a href="{{ route('proposals.download', $proposal->id) }}" class="btn btn-sm btn-primary">  Download Supervisor’s PDF
                            </a>


                            <a href="{{ route('proposals.edit', $proposal->id) }}" class="btn btn-sm btn-warning">Modify</a>
                        </td>
                    </tr>

                    <!-- Modal for Supervisor Comments -->
                    <div class="modal fade" id="commentsModal{{ $proposal->id }}" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Supervisor Comments</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if($proposal->comments->isEmpty())
                                        <p>No comments yet.</p>
                                    @else
                                        <ul class="list-group">
                                            @foreach($proposal->comments as $comment)
                                                <li class="list-group-item">
                                                    <strong>{{ $comment->supervisor->name ?? 'Unknown' }}:</strong> 
                                                    {{ $comment->comment }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
