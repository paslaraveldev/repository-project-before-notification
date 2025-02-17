@extends('layouts.adminconstant')

@section('content')
<div class="container">
    <h2 class="mb-4">Sorted Data</h2>

    <!-- Sorting Dropdown -->
    <form method="GET" action="{{ route('admin.sort.data') }}" class="mb-3">
        <label for="sort_by">Sort By:</label>
        <select name="sort_by" id="sort_by" class="form-control w-25 d-inline">
            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
            <option value="group_id" {{ request('sort_by') == 'group_id' ? 'selected' : '' }}>Group</option>
            <option value="project_type_id" {{ request('sort_by') == 'project_type_id' ? 'selected' : '' }}>Project Type</option>
            <option value="project_year" {{ request('sort_by') == 'project_year' ? 'selected' : '' }}>Project Year</option>
            <option value="submission_date" {{ request('sort_by') == 'submission_date' ? 'selected' : '' }}>Submission Year</option>
            <option value="reviewed_by" {{ request('sort_by') == 'reviewed_by' ? 'selected' : '' }}>Supervisor</option>
        </select>

        <label for="sort_order">Order:</label>
        <select name="sort_order" id="sort_order" class="form-control w-25 d-inline">
            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
        </select>

        <button type="submit" class="btn btn-primary">Sort</button>
    </form>

    <!-- Display Sorted Reports -->
    <h4>Reports</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Group</th>
                <th>Project Type</th>
                <th>Project Year</th>
                <th>Submission Year</th>
                <th>Supervisor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td>{{ $report->title }}</td>
                <td>{{ $report->group->name ?? 'N/A' }}</td>
                <td>{{ $report->projectType->project_type_name ?? 'N/A' }}</td>
                <td>{{ $report->concept->project_year ?? 'N/A' }}</td>
                <td>{{ $report->submission_date }}</td>
                <td>{{ $report->reviewedBy->name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Display Sorted Proposals -->
    <h4>Proposals</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Group</th>
                <th>Project Year</th>
                <th>Supervisor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proposals as $proposal)
            <tr>
                <td>{{ $proposal->title }}</td>
                <td>{{ $proposal->group->name ?? 'N/A' }}</td>
                <td>{{ $proposal->concept->project_year ?? 'N/A' }}</td>
                <td>{{ $proposal->reviewedBy->name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Display Sorted Concepts -->
    <h4>Concepts</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Group</th>
                <th>Project Year</th>
                <th>Updated By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($concepts as $concept)
            <tr>
                <td>{{ $concept->title }}</td>
                <td>{{ $concept->group->name ?? 'N/A' }}</td>
                <td>{{ $concept->project_year }}</td>
                <td>{{ $concept->updatedBy->name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
