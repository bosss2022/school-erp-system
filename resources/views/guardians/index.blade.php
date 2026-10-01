@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Guardians</h3>

        {{-- ✅ Show "Add Guardian" button only to Admins --}}
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('guardians.create') }}" class="btn btn-primary btn-sm">Add Guardian</a>

           @endif
    </div>

      @if(auth()->user()->role === 'admin')
    <!-- Search Form -->
    <form action="{{ route('guardians.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Search by name, email, or phone">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-search"></i> Search
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('guardians.index') }}" class="btn btn-secondary w-100">
                <i class="fa fa-rotate-left"></i> Reset
            </a>
        </div>
    </form>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Assigned Students</th>

                        {{-- ✅ Only show the "Actions" column to Admins --}}
                        @if (auth()->user()->role === 'admin')
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guardians as $guardian)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $guardian->first_name }} {{ $guardian->last_name }}</td>
                            <td>{{ $guardian->email }}</td>
                            <td>{{ $guardian->phone }}</td>
                            <td>
                                @if ($guardian->students->count())
                                    <ul class="mb-0">
                                        @foreach ($guardian->students as $student)
                                            <li>
                                                {{ $student->first_name }} {{ $student->last_name }} 
                                                ({{ $student->admission_no }})
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">No students assigned</span>
                                @endif
                            </td>

                            {{-- ✅ Show action buttons only to Admins --}}
                            @if (auth()->user()->role === 'admin')
                            <td>
                                <a href="{{ route('guardians.show', $guardian->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('guardians.edit', $guardian->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('guardians.destroy', $guardian->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}" class="text-center text-muted">
                                No guardians found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        {{ $guardians->links() }}
    </div>
</div>
@endsection
