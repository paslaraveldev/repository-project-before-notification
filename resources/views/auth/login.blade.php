@extends('layout.studentconstant')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card" style="width: 400px;">
        <div class="card-body">
            <h5 class="card-title text-center">Student Login</h5>
            <h6 class="card-subtitle mb-2 text-muted text-center">Access your account</h6>

            @if(session('error'))
                <p class="alert alert-danger">{{ session('error') }}</p>
            @endif

            <form method="POST" action="{{ route('login.student') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" value="{{ old('email') }}" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url('forgotpassword') }}" class="text-decoration-none">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
            </form>

            <div class="text-center mt-3">
                <p>Don't have an account? <a href="{{ url('registration') }}" class="text-decoration-none">Register</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
