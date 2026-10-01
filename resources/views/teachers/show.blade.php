@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Teacher Details</h3>
    <div class="card p-3">
        <div class="row">
            <div class="col-md-3 text-center">
                @if($teacher->photo)
                    <img src="{{ asset('storage/' . $teacher->photo) }}" width="150" height="150" class="rounded-circle mb-3" alt="Teacher Photo">
                @else
                    <div class="bg-light text-muted p-5 rounded-circle">No Photo</div>
                @endif
            </div>
            <div class="col-md-9">
                <h4>{{ $teacher->first_name }} {{ $teacher->last_name }}</h4>
                <p><strong>Email:</strong> {{ $teacher->email }}</p>
                <p><strong>Phone:</strong> {{ $teacher->phone ?? '—' }}</p>
                <p><strong>Gender:</strong> {{ $teacher->gender ?? '—' }}</p>
            </div>
        </div>
    </div>
   <h5>Subjects Taught</h5>
    @if($teacher->subjects->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Classroom</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teacher->subjects as $subject)
                    <tr>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->classroom->name ?? '—' }}</td>
                        <td>{{ $subject->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No subjects assigned yet.</p>
    @endif

    <a href="{{ route('teachers.index') }}" class="btn btn-secondary mt-3">Back to Teachers</a>
</div>
@endsection
