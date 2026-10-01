@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Guardian Details</h4>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $guardian->first_name }} {{ $guardian->last_name }}</p>
            <p><strong>Email:</strong> {{ $guardian->email }}</p>
            <p><strong>Phone:</strong> {{ $guardian->phone }}</p>
            <p><strong>Address:</strong> {{ $guardian->address ?? '—' }}</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Assigned Students</h5>
        </div>
        <div class="card-body">
            @if($guardian->students->count())
                <div class="row">
                    @foreach($guardian->students as $student)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                @if($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" class="card-img-top" alt="Student Photo" style="height:180px;object-fit:cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title mb-1">{{ $student->first_name }} {{ $student->last_name }}</h6>
                                    <p class="mb-1"><strong>Admission No:</strong> {{ $student->admission_no }}</p>
                                    <p class="mb-1"><strong>Classroom:</strong> {{ $student->classroom->name ?? '—' }}</p>
                                    <p class="mb-1"><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No students assigned to this guardian.</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('guardians.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('guardians.edit', $guardian->id) }}" class="btn btn-primary">Edit Guardian</a>
    </div>
</div>
@endsection
