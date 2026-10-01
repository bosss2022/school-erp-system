
@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow border-0">

        <div class="card-header bg-success text-white">

            <h3 class="mb-0">
                <i class="fa fa-chart-bar me-2"></i>
                Subject Report
            </h3>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('subject.reports') }}"
                  class="row g-3 mb-4">

                {{-- Academic Year --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        Academic Year
                    </label>

                    <select name="academic_year_id"
                            id="academic_year_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Select Academic Year --
                        </option>

                        @foreach($academicYears as $year)

                            <option value="{{ $year->id }}"
                                {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>

                                {{ $year->name }}

                            </option>

                        @endforeach

                    </select>
                </div>

                {{-- Term --}}
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        Term
                    </label>

                    <select name="term"
                            id="term"
                            class="form-select"
                            required>

                        <option value="">
                            -- Select Term --
                        </option>

                    </select>
                </div>

                {{-- Exam --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        Exam
                    </label>

                    <select name="exam_id"
                            id="exam_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Select Exam --
                        </option>

                    </select>
                </div>

                {{-- Classroom --}}
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        Classroom
                    </label>

                    <select name="classroom_id"
                            id="classroom_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Select Classroom --
                        </option>

                        @foreach($classrooms as $class)

                            <option value="{{ $class->id }}"
                                {{ request('classroom_id') == $class->id ? 'selected' : '' }}>

                                {{ $class->name }}

                            </option>

                        @endforeach

                    </select>
                </div>

                {{-- Subject --}}
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        Subject
                    </label>

                    <select name="subject_id"
                            id="subject_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Select Subject --
                        </option>

                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <label>&nbsp;</label>

                    <button class="btn btn-success">

                        <i class="fa fa-search"></i>

                        Generate

                    </button>

                </div>

            </form>

            @if($marks->count())

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="text-success">

                        {{ $marks->first()->subject->name }}

                        Report

                    </h5>

                    <a href="{{ route('subject.reports.pdf', request()->query()) }}"
                       class="btn btn-danger">

                        <i class="fa fa-file-pdf"></i>

                        Download PDF

                    </a>

                </div>

                <table class="table table-bordered table-striped">

                    <thead class="table-success">

                        <tr>

                            <th>#</th>

                            <th>Admission No</th>

                            <th>Student</th>

                            <th>Class</th>

                            <th>Exam</th>

                            <th>Term</th>

                            <th>Marks</th>

                            <th>Grade</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($marks as $mark)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $mark->student->admission_no }}</td>

                                <td>

                                    {{ $mark->student->first_name }}

                                    {{ $mark->student->last_name }}

                                </td>

                                <td>

                                    {{ $mark->student->classroom->name }}

                                </td>

                                <td>

                                    {{ $mark->exam->name }}

                                </td>

                                <td>

                                    {{ $mark->exam->term }}

                                </td>

                                <td>

                                    {{ $mark->marks }}

                                </td>

                                <td>

                                    <span class="badge bg-success">

                                        {{ $mark->grade }}

                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                    <tfoot>

                        <tr class="table-light fw-bold">

                            <td colspan="6">

                                Summary

                            </td>

                            <td>

                                Avg:
                                {{ number_format($averageMark,2) }}

                            </td>

                            <td>

                                High:
                                {{ $highestMark }}

                                <br>

                                Low:
                                {{ $lowestMark }}

                                <br>

                                Students:
                                {{ $totalStudents }}

                            </td>

                        </tr>

                    </tfoot>

                </table>

            @else

                <div class="alert alert-success">

                    No subject report found for the selected filters.

                </div>

            @endif

        </div>

    </div>

</div>

<script>

$(function(){

    // Academic Year -> Terms

    $('#academic_year_id').change(function(){

        let year=$(this).val();

        $('#term').html('<option>Loading...</option>');

        $('#exam_id').html('<option value="">-- Select Exam --</option>');

        if(year){

            $.get('/reports/academic-year/'+year+'/terms',function(data){

                let html='<option value="">-- Select Term --</option>';

                $.each(data,function(i,term){

                    html+=`<option value="${term}">${term}</option>`;

                });

                $('#term').html(html);

            });

        }

    });


    // Term -> Exams

    $('#term').change(function(){

        let year=$('#academic_year_id').val();

        let term=$(this).val();

        $('#exam_id').html('<option>Loading...</option>');

        $.get('/reports/exams',{

            academic_year_id:year,

            term:term

        },function(data){

            let html='<option value="">-- Select Exam --</option>';

            $.each(data,function(i,exam){

                html+=`
                    <option value="${exam.id}">
                        ${exam.name}
                    </option>`;

            });

            $('#exam_id').html(html);

        });

    });


    // Classroom -> Subjects

    $('#classroom_id').change(function(){

        let classroom=$(this).val();

        $('#subject_id').html('<option>Loading...</option>');

        $.get('/subjects-by-classroom/'+classroom,function(data){

            let html='<option value="">-- Select Subject --</option>';

            $.each(data,function(i,subject){

                html+=`
                    <option value="${subject.id}">
                        ${subject.name}
                    </option>`;

            });

            $('#subject_id').html(html);

        });

    });

});

</script>

@endsection
