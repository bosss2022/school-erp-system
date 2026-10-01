@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Student Details</h3>

    <div class="card">
        <div class="card-body">
            {{-- 🖼️ Student Photo --}}
            @if($student->photo)
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/' . $student->photo) }}" 
                         alt="Student Photo" 
                         width="150" 
                         class="rounded-circle shadow">
                </div>
            @endif

            {{-- 📘 Student Info --}}
            <p><strong>Admission No:</strong> {{ $student->admission_no }}</p>
            <p><strong>Full Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Birth Certificate:</strong> {{ $student->phone }}</p>
            <p><strong>Date of Birth:</strong> {{ $student->dob ?? '—' }}</p>
            <p><strong>Address:</strong> {{ $student->address ?? '—' }}</p>
            <p><strong>Classroom:</strong> {{ $student->classroom->name ?? '—' }}</p>
        </div>
    </div>

    {{-- 👨‍👩 Guardian Info --}}
    <div class="card mt-4">
        <div class="card-header bg-primary text-white fw-semibold">
            Guardian Information
        </div>
        <div class="card-body">
            @if($student->guardian)
                <p><strong>Name:</strong> {{ $student->guardian->first_name }} {{ $student->guardian->last_name }}</p>
                <p><strong>Phone:</strong> {{ $student->guardian->phone }}</p>
                <p><strong>Email:</strong> {{ $student->guardian->email ?? '—' }}</p>
                <p><strong>Relation:</strong> {{ $student->guardian->relation ?? '—' }}</p>
                <p><strong>Address:</strong> {{ $student->guardian->address ?? '—' }}</p>
            @else
                <p class="text-muted">No guardian assigned to this student.</p>
            @endif
        </div>
    </div>

    {{-- 🔙 Actions --}}
    <div class="mt-3">
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Delete this student?')">Delete</button>
        </form>
    </div>
</div>
@endsection
