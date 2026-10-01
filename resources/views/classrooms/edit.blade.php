@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Class</h3>
    <form action="{{ route('classrooms.update', $classroom) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Class Name</label>
            <input type="text" name="name" value="{{ $classroom->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Class Teacher</label>
            <select name="teacher_id" class="form-control">
                <option value="">-- Select Teacher --</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $classroom->teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </option>
                @endforeach
            </select>
                         

        </div>
        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" value="{{ $classroom->capacity }}" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
