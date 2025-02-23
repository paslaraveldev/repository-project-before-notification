@extends('layouts.adminconstant')

@section('content')
    <div class="container">
        <h2 class="mb-4">Your Profile</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>

                <!-- Image Upload and Display -->
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="image">Profile Image</label>
                        <input type="file" name="image" class="form-control">
                        @if($user->image)
                            <img src="{{ asset('images/users/' . $user->image) }}" class="card-img-bottom mt-3" alt="Profile Image" width="100%">
                        @else
                            <p class="text-muted mt-2">No profile image uploaded.</p>
                        @endif
                    </div>

                    <div class="form-group mt-3">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
@endsection
