@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Student Report Cards</h3>
    <hr>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Class</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                <td>{{ $student->classroom->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('report-card.show', $student->id) }}" class="btn btn-sm btn-primary">View Report</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
