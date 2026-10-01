@extends('layouts.pdf')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $exam->name }} - Exam Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        h3, p { text-align: center; margin: 0; }
        .header { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h3>{{ $exam->name }} - Exam Report</h3>
        <p>Term: {{ $exam->term ?? 'N/A' }}</p>
        <p>Class: {{ $classroomName ?? 'All Classes' }}</p>
        <p>Exam Date: {{ $exam->exam_date ?? 'N/A' }}</p>
    </div>

    @if($students->isEmpty())
        <p style="text-align:center;">No student marks found for this exam.</p>
    @else
        @php
            // Collect all subjects appearing in this exam
            $subjects = $students->flatMap(function($marks) {
                return $marks->pluck('subject.name');
            })->unique()->values();
        @endphp

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Admission No</th>
                    @foreach($subjects as $subject)
                        <th>{{ $subject }}</th>
                    @endforeach
                    <th>Total</th>
                    <th>Average</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $studentMarks)
                    @php
                        $student = $studentMarks->first()->student;
                        $total = $studentMarks->sum('marks');
                        $subjectMarks = $studentMarks->pluck('marks', 'subject.name');
                        $average = count($subjects) ? round($total / count($subjects), 2) : 0;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->admission_no }}</td>

                        @foreach($subjects as $subject)
                            <td>{{ $subjectMarks[$subject] ?? '-' }}</td>
                        @endforeach

                        <td>{{ $total }}</td>
                        <td>{{ $average }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
@endsection