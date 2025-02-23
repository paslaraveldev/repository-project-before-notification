@extends('layout.studentconstant')

@section('content')
<div class="container">
    <h2>{{ $report->title }}</h2>
    @if ($report->image)
        <p><strong>Image:</strong> <br> <img src="{{ asset($report->image) }}" alt="Report Image" width="200"></p>
    @endif

    <p><strong>Abstract:</strong> {{ $report->abstract }}</p>
    <p><strong>Description:</strong> {{ $report->description }}</p>

    <p><strong>Authors:</strong> 
        @foreach($report->group->students as $student)
            {{ $student->name }}{{ !$loop->last ? ', ' : '' }}
        @endforeach
    </p>

    <p><strong>Video Link:</strong> <a href="{{ $report->video_link }}" target="_blank">{{ $report->video_link }}</a></p>
    
    <p><strong>PDF File:</strong> <a href="{{ asset($report->pdf_file) }}" target="_blank">View PDF</a></p>

    
</div>
@endsection
