@extends('layouts.adminconstant')

@section('content')
<div class="container">
    <h3>Search Results for "{{ $query }}"</h3>

    @if($concepts->isEmpty() && $courses->isEmpty() && $departments->isEmpty() && $groups->isEmpty() && $proposals->isEmpty() && $reports->isEmpty() && $users->isEmpty())
        <p>No results found.</p>
    @else
        @if(!$concepts->isEmpty())
            <h4>Concepts</h4>
            <ul>
                @foreach($concepts as $concept)
                    <li><strong>{{ $concept->title }}</strong> - {{ $concept->description }}</li>
                @endforeach
            </ul>
        @endif

        @if(!$courses->isEmpty())
            <h4>Courses</h4>
            <ul>
                @foreach($courses as $course)
                    <li>{{ $course->name }}</li>
                @endforeach
            </ul>
        @endif

        @if(!$departments->isEmpty())
            <h4>Departments</h4>
            <ul>
                @foreach($departments as $department)
                    <li>{{ $department->name }}</li>
                @endforeach
            </ul>
        @endif

        @if(!$groups->isEmpty())
            <h4>Groups</h4>
            <ul>
                @foreach($groups as $group)
                    <li>{{ $group->name }}</li>
                @endforeach
            </ul>
        @endif

        @if(!$proposals->isEmpty())
            <h4>Proposals</h4>
            <ul>
                @foreach($proposals as $proposal)
                    <li><strong>{{ $proposal->title }}</strong> - {{ $proposal->description }}</li>
                @endforeach
            </ul>
        @endif

        @if(!$reports->isEmpty())
            <h4>Reports</h4>
            <ul>
                @foreach($reports as $report)
                    <li><strong>{{ $report->title }}</strong> - {{ $report->abstract }}</li>
                @endforeach
            </ul>
        @endif

        @if(!$users->isEmpty())
            <h4>Users</h4>
            <ul>
                @foreach($users as $user)
                    <li>{{ $user->name }} ({{ $user->email }})</li>
                @endforeach
            </ul>
        @endif
    @endif
</div>
@endsection
