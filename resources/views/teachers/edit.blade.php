@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Teacher</h3>
    <form action="{{ route('teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ $teacher->first_name }}" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ $teacher->last_name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $teacher->email }}" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $teacher->phone }}">
        </div>

        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control">
                <option value="">Select</option>
                <option value="Male" {{ $teacher->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $teacher->gender == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ $teacher->gender == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Current Photo</label><br>
            @if($teacher->photo)
                <img src="{{ asset('storage/' . $teacher->photo) }}" width="100" height="100" class="rounded mb-2" alt="Teacher Photo">
            @else
                <p>No photo uploaded</p>
            @endif
        </div>

        <div class="mb-3">
            <label>Change Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
