@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Subject Details</h3>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $subject->name }}</h5>
            <p><strong>Classroom:</strong> {{ $subject->classroom->name ?? '—' }}</p>
            <p><strong>Teacher:</strong> 
                {{ $subject->teacher ? $subject->teacher->first_name . ' ' . $subject->teacher->last_name : '—' }}
            </p>
            <p><strong>Created At:</strong> {{ $subject->created_at->format('Y-m-d') }}</p>
        </div>
    </div>

    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning mt-3">Edit</a>
    <a href="{{ route('subjects.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
