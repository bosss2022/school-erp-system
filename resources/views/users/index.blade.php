@extends('layouts.app')

@section('content')
<div class="container">
   <div class="d-flex justify-content-end mb-3">

    <a href="{{ route('users.create') }}" class="btn btn-success me-2">
        <i class="fa-solid fa-user-plus"></i> Add User
    </a>

    <a href="{{ route('users.download') }}" class="btn btn-danger">
        <i class="fa-solid fa-file-pdf"></i> Download PDF
    </a>

</div>
 
    <h3 class="mb-3">Manage Users</h3>

    <!-- Search Form -->
    <form action="{{ route('users.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Search by name, email or role">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-search"></i> Search
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">
                <i class="fa fa-rotate-left"></i> Reset
            </a>
        </div>
    </form>

    <!-- Users Table -->
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection
