@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">My Subjects</h4>

    @if($subjects->count())
        <div class="row">
            @foreach($subjects as $subject)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">{{ $subject->name }}</h5>
                            <p class="mb-1"><strong>Teacher:</strong>
                                {{ $subject->teacher->first_name ?? 'N/A' }}
                                {{ $subject->teacher->last_name ?? '' }}
                            </p>
                            <p class="text-muted">
                                <strong>Email:</strong> {{ $subject->teacher->email ?? 'N/A' }}<br>
                                <strong>Phone:</strong> {{ $subject->teacher->phone ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">No subjects assigned yet.</p>
    @endif
</div>
@endsection
