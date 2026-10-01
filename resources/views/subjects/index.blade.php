@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Subjects</h3>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('subjects.create') }}" class="btn btn-primary">Add Subject</a>
            
        @endif
    </div>

    {{-- Role-specific info --}}
    @if(auth()->user()->role === 'student')
        <p class="text-muted">You only see subjects assigned to your classroom.</p>
    @elseif(auth()->user()->role === 'teacher')
        <p class="text-muted">You only see subjects you teach.</p>
    @endif

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    {{-- Search form --}}
    <form method="GET" action="{{ route('subjects.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" 
               placeholder="Search subject name..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-secondary">Search</button>
    </form>

    {{-- Subjects table --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Subject Name</th>
                    <th>Teacher</th>
                    <th>Classroom</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->teacher ? $subject->teacher->first_name . ' ' . $subject->teacher->last_name : '—' }}</td>
                        <td>{{ $subject->classroom->name ?? '—' }}</td>
                        <td>{{ $subject->created_at->format('Y-m-d') }}</td>
                        <td>
                            {{-- View button --}}
                            <a href="{{ route('subjects.show', $subject) }}" class="btn btn-sm btn-info">View</a>

                            {{-- Admin-only actions --}}
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this subject?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No subjects found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $subjects->links() }}
    </div>
</div>
@endsection
