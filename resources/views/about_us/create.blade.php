@extends('layout.studentconstant')
@section('content')
<div class="container">
    <h1>Create About Us</h1>
    <form action="{{ route('about.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Purpose</label>
            <input type="text" name="purpose" class="form-control" placeholder="Purpose" required>
        </div>
        <div class="form-group">
            <label>Mission</label>
            <input type="text" name="mission" class="form-control" placeholder="Mission" required>
        </div>
        <div class="form-group">
            <label>Vision</label>
            <input type="text" name="vision" class="form-control" placeholder="Vision" required>
        </div>
        <div class="form-group">
            <label>Features</label>
            <textarea name="features" class="form-control" placeholder="Features" required></textarea>
        </div>
        <div class="form-group">
            <label>Audience</label>
            <textarea name="audience" class="form-control" placeholder="Audience" required></textarea>
        </div>
        <div class="form-group">
            <label>Workflow</label>
            <textarea name="workflow" class="form-control" placeholder="Workflow" required></textarea>
        </div>
        <div class="form-group">
            <label>Policies</label>
            <textarea name="policies" class="form-control" placeholder="Policies" required></textarea>
        </div>
        <div class="form-group">
            <label>Team</label>
            <textarea name="team" class="form-control" placeholder="Team" required></textarea>
        </div>
        <div class="form-group">
            <label>Phone 1</label>
            <input type="text" name="phone1" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Phone 2</label>
            <input type="text" name="phone2" class="form-control">
        </div>
        <div class="form-group">
            <label>Phone 3</label>
            <input type="text" name="phone3" class="form-control">
        </div>
        <div class="form-group">
            <label>Phone 4</label>
            <input type="text" name="phone4" class="form-control">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>P.O. Box</label>
            <input type="text" name="po_box" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
