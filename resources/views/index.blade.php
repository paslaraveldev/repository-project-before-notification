@extends('layout.studentconstant')

@section('content')

<!-- Hero Section -->
<div class="hero">
    <h1>Empowering Research, Innovation & Collaboration</h1>
   
</div>
<div class="container">
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


<h2>Latest Reports</h2>
<div class="row">
    @foreach($latestReports as $report)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $report->title }}</h5>
                    <p class="card-text">{{ Str::limit($report->abstract, 100) }}</p> <!-- Short abstract preview -->

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


<!-- Pagination Links for Reports -->
<div class="mt-4 d-flex justify-content-center">
    {{ $latestReports->links() }}
</div>





<!-- About Section -->
<!-- About Us Section -->
<section id="about">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">About Us</h2>
                
                <h5 class="fw-bold">Purpose</h5>
                <p>{{ $about->purpose }}</p>

                <h5 class="fw-bold">Mission</h5>
                <p>{{ $about->mission }}</p>

                <h5 class="fw-bold">Vision</h5>
                <p>{{ $about->vision }}</p>
            </div>
        </div>
    </div>
</section>


<!-- Supervisors Section -->
<section id="supervisors">
    <h2>Meet Our Supervisors</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Supervisors</h5>

            <!-- Bootstrap Carousel -->
            <div id="supervisorCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($users->chunk(3) as $index => $userChunk)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row text-center">
                                @foreach ($userChunk as $user)
                                    <div class="col-md-4">
                                        <img src="{{ asset('images/users/'.$user->image) }}" class="d-block mx-auto rounded-circle" alt="{{ $user->name }}" style="width: 150px; height: 150px;">
                                        <h3 class="mt-3">{{ $user->name }}</h3>
                                        <p>{{ $user->department }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#supervisorCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#supervisorCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div><!-- End Carousel -->

        </div>
    </div>
</section>

<!-- Latest Reports Section -->
<section id="latest-reports">
    <h2>Latest Reports</h2>
    <ul>
        @foreach ($latestReports as $report)
            <li>
                <h4>{{ $report->title }}</h4>
                <p>{{ Str::limit($report->abstract, 100) }}</p>
                <a href="{{ route('report.show', $report->id) }}" class="btn-secondary">View Full Report</a>
            </li>
        @endforeach
    </ul>
</section>

<!-- Departments & Courses Section -->
<section id="departments-courses">
    <h2>Departments & Courses</h2>
    <div class="departments">
        @foreach ($departments as $department)
            <div class="department">
                <h3>{{ $department->name }}</h3>
                <p>Head of Department: {{ $department->head->name }}</p>
                <ul>
                    @foreach ($courses->where('department_id', $department->id) as $course)
                        <li>{{ $course->name }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</section>

@endsection
