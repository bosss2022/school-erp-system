@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h3>{{ $student->first_name }} {{ $student->last_name }}</h3>
            <h5>Academic Year: {{ $academicYear->name }}</h5>
        </div>

        <div class="card-body">

        <div class="mb-3 text-end">

    <a href="{{ route('report-card.year.download', [
        'student' => $student->id,
        'academicYear' => $academicYear->id,
    ]) }}"
    class="btn btn-danger">

        <i class="fa fa-file-pdf"></i>

        Download PDF

    </a>

</div>

            @forelse($results as $term => $marks)

                <div class="card mb-4">

                    <div class="card-header bg-light">
                        <strong>{{ $term }}</strong>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">

                            <thead>

                                <tr>
                                    <th>Subject</th>
                                    <th>Exam</th>
                                    <th>Marks</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($marks as $mark)

                                    <tr>

                                        <td>{{ $mark->subject->name }}</td>

                                        <td>{{ $mark->exam->name }}</td>

                                        <td>{{ $mark->marks }}</td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @empty

                <div class="alert alert-warning">
                    No results found for this academic year.
                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection