@extends('layout.studentconstant')

@section('content')

<!-- Hero Section -->
<div class="hero">
    <h1>Empowering Research, Innovation & Collaboration</h1>
</div>

<div class="container">
    <!-- Latest Concepts Section -->
    <h2>Latest Concepts</h2>
    <div class="row">
        @foreach($publicConcepts as $concept)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $concept->title }}</h5>
                        <p class="card-text">{{ $concept->description }}</p>
                        <p><strong>Abstract:</strong> {{ $concept->main_objective }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {!! $publicConcepts->links('vendor.pagination.custom') !!}
    </div>

    <!-- Latest Proposals Section -->
    <h2>Latest Proposals</h2>
    <div class="row">
        @foreach($latestProposals as $proposal)
            <div class="col-md-4">
                <div class="card">
                    @if($proposal->image)
                        <img src="{{ asset('images/proposals/' . $proposal->image) }}" class="card-img-top w-100" style="height: 200px; object-fit: cover;" alt="Proposal Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $proposal->title }}</h5>
                        <p class="card-text">{{ $proposal->description }}</p>
                        @auth
                            <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-primary">Read More</a>
                        @else
                            <a href="/login" class="btn btn-warning">Login to View Full Proposal</a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {!! $latestProposals->links('vendor.pagination.custom') !!}
    </div>

    <!-- Latest Reports Section -->
    <h2>Latest Reports</h2>
    <div class="row">
        @foreach($latestReports as $report)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $report->title }}</h5>
                        <p class="card-text">{{ Str::limit($report->abstract, 100) }}</p>
                        @auth
                            <a href="{{ route('report.show', $report->id) }}" class="btn btn-primary">Read More</a>
                        @else
                            <a href="/login" class="btn btn-warning">Login to Read More</a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {!! $latestReports->links('vendor.pagination.custom') !!}
    </div>
</div>

@endsection
