@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{ $classroom->name }} - {{ $exam->name }} Results</h3>
        <a href="{{ route('results.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @foreach ($classroom->students as $student)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between">
                <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>
                <span>Overall Grade: <strong>{{ $student->overall_grade }}</strong></span>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Subject</th>
                            <th>Marks</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($student->marks as $mark)
                            <tr>
                                <td>{{ $mark->subject->name }}</td>
                                <td>{{ $mark->marks }}</td>
                                <td>{{ $mark->grade }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No marks recorded</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary">
                            <th>Total</th>
                            <th>{{ $student->total_marks }}</th>
                            <th></th>
                        </tr>
                        <tr class="table-secondary">
                            <th>Average</th>
                            <th>{{ $student->average }}</th>
                            <th>{{ $student->overall_grade }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
