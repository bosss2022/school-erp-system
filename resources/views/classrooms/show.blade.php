@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Classroom: {{ $classroom->name }} {{ $classroom->section ? '('.$classroom->section.')' : '' }}</h3>
        <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">← Back to Classes</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Class Name & Section:</strong> {{ $classroom->name }}</p>
            <p><strong>Class Teacher:</strong> {{ $classroom->teacher ? $classroom->teacher->first_name . ' ' . $classroom->teacher->last_name : '—' }}</p>
            <p><strong>Total Students:</strong> {{ $classroom->students->count() }}</p>
        </div>
    </div>

    <h5>Students in this Class</h5>

    @if($classroom->students->isEmpty())
        <div class="alert alert-info">No students enrolled in this class yet.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Admission No</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Birth Certificate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classroom->students as $student)
                    <tr>
                        <td>{{ $student->admission_no }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>
                             @if(auth()->user()->role === 'admin')
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                             @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
