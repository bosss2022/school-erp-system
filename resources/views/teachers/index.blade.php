@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Teachers</h3>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary">Add Teacher</a>
    </div>


    <!-- Search Form -->
    <form action="{{ route('teachers.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Search by name or email">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-search"></i> Search
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary w-100">
                <i class="fa fa-rotate-left"></i> Reset
            </a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teachers as $teacher)
            <tr>
                <td>
                    @if($teacher->photo)
                        <img src="{{ asset('storage/' . $teacher->photo) }}" width="50" height="50" class="rounded-circle" alt="Photo">
                    @else
                        —
                    @endif
                </td>
                <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->phone ?? '—' }}</td>
                <td>{{ $teacher->gender ?? '—' }}</td>
                <td>
                    <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this teacher?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $teachers->links() }}
</div>
@endsection
