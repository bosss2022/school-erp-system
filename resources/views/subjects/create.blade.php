@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Subject</h3>
    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf

    <div class="mb-3">
    <label class="form-label">Subject Name</label>
    <select name="name" class="form-select" required>
        <option value="">-- Select Subject --</option>
        <option value="Mathematics">Mathematics</option>
        <option value="English">English</option>
        <option value="Kiswahili">Kiswahili</option>
        <option value="Science and Technology">Science and Technology</option>
        <option value="Religious Activities">Religious Activities</option>
        <option value="Environmetal Activities">Environmetal Activities</option>
        <option value="Literacy">Literacy</option>
        <option value="Home Science/Agriculture">Home Science/Agriculture</option>
        <option value="Music/Creative activities ">Music/Creative activities </option>
        <option value="Psychomotor(PE)">Psychomotor(PE)</option>
        <option value="Fee Structure">Fee Structure</option>
    </select>
</div>

        <div class="mb-3">
            <label class="form-label">Classroom</label>
            <select name="classroom_id" class="form-control">
                <option value="">Select Classroom</option>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Teacher</label>
            <select name="teacher_id" class="form-control">
                <option value="">Select Teacher</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
