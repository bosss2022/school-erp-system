@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Student</h3>
    <form action="{{ route('students.update', $student) }}" method="POST"  enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Admission No</label>
            <input type="text" name="admission_no" class="form-control" value="{{ old('admission_no', $student->admission_no) }}" required>
        </div>
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $student->first_name) }}" required>
        </div>
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $student->last_name) }}">
        </div>
        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="">Select</option>
                <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ $student->gender == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}">
        </div>
        <div class="mb-3">
            <label>Birth Certificate</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
        </div>
        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="{{ old('dob', $student->dob) }}">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ old('address', $student->address) }}</textarea>
        </div>
       
         <div class="mb-3">
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


        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
