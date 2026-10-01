@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">My Report Card</h3>

    <div class="card mb-4">
        <div class="card-body">
            <strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}<br>
            <strong>Admission No:</strong> {{ $student->admission_no }}<br>
            <strong>Class:</strong> {{ $student->classroom->name ?? '—' }}
        </div>
    </div>

    @foreach ($reports as $report)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between">
                <strong>{{ $report['exam'] }}</strong>
                <span>Overall Grade: <strong>{{ $report['grade'] }}</strong></span>
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
                        @foreach ($report['marks'] as $mark)
                            <tr>
                                <td>{{ $mark->subject->name }}</td>
                                <td>{{ $mark->marks }}</td>
                                <td>{{ $mark->grade }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary">
                            <th>Total</th>
                            <th>{{ $report['total'] }}</th>
                            <th></th>
                        </tr>
                        <tr class="table-secondary">
                            <th>Average</th>
                            <th>{{ $report['average'] }}</th>
                            <th>{{ $report['grade'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
