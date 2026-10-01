@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-2">Exam Reports</h3>
    <p class="text-muted">
        Select Academic Year, Term, Exam and Class to view the overall exam report.
    </p>

    <form action="{{ route('exams.report') }}" method="GET" class="row g-3 mb-4">

        {{-- Academic Year --}}
        <div class="col-md-3">
            <label class="form-label">Academic Year</label>
            <select name="academic_year_id" id="academic_year_id" class="form-select" required>
                <option value="">-- Select Academic Year --</option>

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
            <label class="form-label">Term</label>
            <select name="term" id="term" class="form-select" required>
                <option value="">-- Select Term --</option>
            </select>
        </div>

        {{-- Exam --}}
        <div class="col-md-3">
            <label class="form-label">Exam</label>
            <select name="exam_id" id="exam_id" class="form-select" required>
                <option value="">-- Select Exam --</option>
            </select>
        </div>

        {{-- Classroom --}}
        <div class="col-md-3">
            <label class="form-label">Class</label>
            <select name="classroom_id" class="form-select">
                <option value="">All Classes</option>

                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}"
                        {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-1 d-grid">
            <button class="btn btn-success">
                View
            </button>
        </div>

    </form>

    @if(isset($exam) && $students->isNotEmpty())

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4>{{ $exam->name }}</h4>

                <small class="text-muted">

                    Academic Year:
                    {{ $exam->academicYear->name ?? '-' }}

                    |

                    Term:
                    {{ $exam->term }}

                    |

                    Class:
                    {{ $classroomName ?? 'All Classes' }}

                </small>

            </div>
@if($exam)
    <a href="{{ route('exams.report.pdf', [
        'exam' => $exam->id,
        'classroom_id' => request('classroom_id'),
        'term' => request('term'),
    ]) }}" class="btn btn-danger">
        Download PDF
    </a>
@endif

        </div>

        @foreach($students as $studentMarks)

            @php

                $student = $studentMarks->first()->student;

                $total = $studentMarks->sum('marks');

                $average = number_format($studentMarks->avg('marks'),2);

            @endphp

            <div class="card shadow-sm mb-4">

                <div class="card-header bg-success text-white">

                    <div class="d-flex justify-content-between">

                        <div>

                            <strong>

                                {{ $student->first_name }}
                                {{ $student->last_name }}

                            </strong>

                            ({{ $student->admission_no }})

                        </div>

                        <div>

                            {{ $student->classroom->name ?? '' }}

                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <thead class="table-light">

                        <tr>

                            <th>Subject</th>

                            <th width="120">Marks</th>

                            <th width="120">Grade</th>

                        </tr>

                        </thead>

                        <tbody>

                        @foreach($studentMarks as $mark)

                            <tr>

                                <td>{{ $mark->subject->name }}</td>

                                <td>{{ $mark->marks }}</td>

                                <td>{{ $mark->grade }}</td>

                            </tr>

                        @endforeach

                        </tbody>

                        <tfoot>

                        <tr class="table-secondary fw-bold">

                            <td>Total</td>

                            <td colspan="2">

                                {{ $total }}

                            </td>

                        </tr>

                        <tr class="table-success fw-bold">

                            <td>Average</td>

                            <td colspan="2">

                                {{ $average }}

                            </td>

                        </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        @endforeach

    @elseif(request()->filled('exam_id'))

        <div class="alert alert-info">

            No marks found for the selected filters.

        </div>

    @endif

</div>

<script>

$(function () {

    //----------------------------------------------------
    // Academic Year -> Terms
    //----------------------------------------------------

    $('#academic_year_id').change(function () {

        let id = $(this).val();

        $('#term').html('<option>Loading...</option>');

        $('#exam_id').html('<option value="">-- Select Exam --</option>');

        if(id){

            $.get('/reports/academic-year/' + id + '/terms', function (data){

                let html = '<option value="">-- Select Term --</option>';

                $.each(data,function(index,term){

                    html += `<option value="${term}">${term}</option>`;

                });

                $('#term').html(html);

            });

        }

    });

    //----------------------------------------------------
    // Term -> Exams
    //----------------------------------------------------

    $('#term').change(function(){

        let year = $('#academic_year_id').val();

        let term = $(this).val();

        $('#exam_id').html('<option>Loading...</option>');

        if(year && term){

            $.get('/reports/exams',{

                academic_year_id:year,

                term:term

            },function(data){

                let html='<option value="">-- Select Exam --</option>';

                $.each(data,function(index,exam){

                    html += `<option value="${exam.id}">
                                ${exam.name}
                                (${exam.exam_date})
                             </option>`;

                });

                $('#exam_id').html(html);

            });

        }

    });

    //----------------------------------------------------
    // Restore values after validation/filter
    //----------------------------------------------------

    @if(request('academic_year_id'))

        $('#academic_year_id').trigger('change');

        setTimeout(function(){

            $('#term').val('{{ request("term") }}').trigger('change');

        },400);

        setTimeout(function(){

            $('#exam_id').val('{{ request("exam_id") }}');

        },800);

    @endif

});

</script>

@endsection