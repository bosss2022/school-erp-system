@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Subject</h3>
    <form action="{{ route('subjects.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $subject->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Classroom</label>
            <select name="classroom_id" class="form-control">
                <option value="">Select Classroom</option>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" 
                        {{ $subject->classroom_id == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Teacher</label>
            <select name="teacher_id" class="form-control">
                <option value="">Select Teacher</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" 
                        {{ $subject->teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
