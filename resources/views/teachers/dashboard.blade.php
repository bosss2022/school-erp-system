@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Profile Card (Smaller) -->
    <div class="card shadow-sm mb-4" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body text-center p-3">
            <img src="{{ asset('storage/' . $teacher->photo) }}" 
                 alt="Teacher Photo" 
                 class="rounded-circle mb-2 shadow-sm" 
                 width="90" height="90">

            <h5 class="mb-1">{{ $teacher->first_name }} {{ $teacher->last_name }}</h5>
            <p class="text-muted small mb-2">{{ $teacher->email }}</p>

            <div class="d-flex justify-content-center small text-secondary">
                <div class="px-2"><strong>Phone:</strong> {{ $teacher->phone }}</div>
                <div class="px-2 border-start"><strong>Gender:</strong> {{ ucfirst($teacher->gender) }}</div>
            </div>
        </div>
    </div>

    <!-- Teacher Info Sections -->
    <div class="row">
        <!-- Subjects -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white py-2">
                    <h6 class="mb-0">Subjects You Teach</h6>
                </div>
                <div class="card-body p-3">
                    @if($teacher->subjects->count())
                        <ul class="list-group list-group-flush small">
                            @foreach($teacher->subjects as $subject)
                                <li class="list-group-item py-2">{{ $subject->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted small mb-0">No subjects assigned yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Classes -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white py-2">
                    <h6 class="mb-0">Your Classes</h6>
                </div>
                <div class="card-body p-3">
                    @if($teacher->classrooms->count())
                        <ul class="list-group list-group-flush small">
                            @foreach($teacher->classrooms as $classroom)
                                <li class="list-group-item py-2">{{ $classroom->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted small mb-0">No classes assigned yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
