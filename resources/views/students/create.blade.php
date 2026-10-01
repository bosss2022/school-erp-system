@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Add leader</h3>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="admission_no" class="form-label">Admission No</label>
                <input type="text" name="admission_no" id="admission_no" class="form-control" value="{{ old('admission_no') }}" required>
            </div>
            <div class="col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
            </div>
            <div class="col-md-6">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Birth Certificate</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
            </div>

             <div class="col-md-6">
            <label>Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
        </div>
        </div>


        <div class="col-md-6">
    <label>Classroom</label>
    <select name="classroom_id" class="form-control">
        <option value="">Select Class</option>
        @foreach ($classrooms as $classroom)
            <option value="{{ $classroom->id }}" 
                {{ old('classroom_id', $student->classroom_id ?? '') == $classroom->id ? 'selected' : '' }}>
                {{ $classroom->name }}
            </option>
        @endforeach
    </select>
</div>

       
        <div class="mb-3">
    <label>Profile Photo</label>
    <input type="file" name="photo" class="form-control">
    @if(isset($student) && $student->photo)
        <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" width="100" class="mt-2">
    @endif
</div>


        <button type="submit" class="btn btn-primary">Save leader</button>
    </form>
</div>
@endsection
