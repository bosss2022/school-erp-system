@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit User</h3>
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label>New Password (optional)</label>
            <input name="password" type="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <option value="admin" @selected($user->role == 'admin')>Admin</option>
                <option value="teacher" @selected($user->role == 'teacher')>Teacher</option>
                <option value="student" @selected($user->role == 'student')>Student</option>
            </select>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
