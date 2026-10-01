@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Classes</h3>

        {{-- Only admin can add new classes --}}
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('classrooms.create') }}" class="btn btn-primary">Add Class</a>
        @endif
    </div>
         <form action="{{ route('classrooms.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Search classrooms or teacher name">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-search"></i> Search
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('classrooms.index') }}" class="btn btn-secondary w-100">
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
                <th>Class Name</th>
                <th>Class Teacher</th>
                <th>Capacity</th>
                <th>Students</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($classrooms as $classroom)
                <tr>
                    <td>{{ $classroom->name }}</td>
                    <td>
                        {{ $classroom->teacher ? $classroom->teacher->first_name . ' ' . $classroom->teacher->last_name : '—' }}
                    </td>
                    <td>{{ $classroom->capacity }}</td>
                    <td>{{ $classroom->students->count() }}</td>

                    <td>
                        {{-- All users can view --}}
                        <a href="{{ route('classrooms.show', $classroom->id) }}" class="btn btn-sm btn-info">View</a>

                        {{-- Only admin can edit/delete --}}
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('classrooms.edit', $classroom) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this class?')">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $classrooms->links() }}
</div>
@endsection
