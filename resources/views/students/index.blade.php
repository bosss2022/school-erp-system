@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Leaders</h3>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add leader</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

      <div class="card mb-3 p-3">
    <form method="GET" action="{{ route('students.index') }}" class="row g-2 align-items-center">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name or admission no...">
        </div>
        <div class="col-md-3">
            <select name="gender" class="form-select">
                <option value="">All Genders</option>
                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('students.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>
</div>






    <table class="table table-striped">
        <thead>
            <tr>
                <th>Admission No</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Birth Certificate</th>
                <th>Classroom</th>
                <th>Academic Year</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->admission_no }}</td>
          <td> <a href="{{ route('students.show', $student) }}">
                {{ $student->first_name }} {{ $student->last_name }}  </a> </td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->phone }}</td>
                <td>{{ $student->classroom->name ?? '—' }}</td>
                <td>{{ $student->academic_year }}</td>

                <td>
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this student?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $students->links() }}
</div>
@endsection
