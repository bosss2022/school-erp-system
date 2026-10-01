@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                <i class="fa-solid fa-pen me-2"></i>
                Record Student Marks
            </h4>
        </div>

        <div class="card-body">

            <form action="{{ route('marks.store') }}" method="POST">

                @csrf

                <div class="row">

                    <!-- Academic Year -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Academic Year</label>

                        <select id="academic_year_id"
                                name="academic_year_id"
                                class="form-select"
                                required>

                            <option value="">Select Academic Year</option>

                            @foreach($academicYears as $year)

                                <option value="{{ $year->id }}">
                                    {{ $year->name }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <!-- Term -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Term

                        </label>

                        <select id="term"
                                class="form-select"
                                required>

                            <option value="">

                                Select Academic Year First

                            </option>

                        </select>

                    </div>

                    <!-- Exam -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Exam

                        </label>

                        <select
                            id="exam_id"
                            name="exam_id"
                            class="form-select"
                            required>

                            <option value="">

                                Select Term First

                            </option>

                        </select>

                    </div>

                </div>


                <div class="row">

                    <!-- Classroom -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Classroom

                        </label>

                        <select
                            id="classroom_id"
                            name="classroom_id"
                            class="form-select"
                            required>

                            <option value="">

                                Select Classroom

                            </option>

                            @foreach($classrooms as $classroom)

                                <option value="{{ $classroom->id }}">

                                    {{ $classroom->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- Subject -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Subject

                        </label>

                        <select
                            id="subject_id"
                            name="subject_id"
                            class="form-select"
                            required>

                            <option value="">

                                Select Classroom First

                            </option>

                        </select>

                    </div>

                </div>


                <hr>

                <div id="students-section">

                    <div class="text-center text-muted">

                        Select a classroom to load students.

                    </div>

                </div>

                <button class="btn btn-success mt-3">

                    <i class="fa-solid fa-save me-2"></i>

                    Save Marks

                </button>

            </form>

        </div>

    </div>

</div>

  <script>
// ----------------------------
// Academic Year -> Terms
// ----------------------------
$('#academic_year_id').change(function () {

    let yearId = $(this).val();

    $('#term').html('<option>Loading...</option>');
    $('#exam_id').html('<option>Select Term First</option>');

    if(yearId){

        $.get('/marks/academic-year/' + yearId + '/terms', function(terms){

            let options = '<option value="">Select Term</option>';

            terms.forEach(function(term){

                options += `<option value="${term}">${term}</option>`;

            });

            $('#term').html(options);

        });

    }

});


// ----------------------------
// Term -> Exams
// ----------------------------
$('#term').change(function(){

    let yearId = $('#academic_year_id').val();

    let term = $(this).val();

    $('#exam_id').html('<option>Loading...</option>');

    $.get('/marks/exams',{

        academic_year_id:yearId,

        term:term

    },function(exams){

        let options='<option value="">Select Exam</option>';

        exams.forEach(function(exam){

            options +=
            `<option value="${exam.id}">
                ${exam.name}
            </option>`;

        });

        $('#exam_id').html(options);

    });

});


// ----------------------------
// Classroom -> Subjects
// ----------------------------
$('#classroom_id').change(function(){

    let classroomId=$(this).val();

    $('#subject_id').html('<option>Loading...</option>');

    $.get('/subjects-by-classroom/'+classroomId,function(subjects){

        let options='<option value="">Select Subject</option>';

        subjects.forEach(function(subject){

            options +=
            `<option value="${subject.id}">
                ${subject.name}
            </option>`;

        });

        $('#subject_id').html(options);

    });

});


// ----------------------------
// Classroom -> Students
// ----------------------------
$('#classroom_id').change(function(){

    let classroomId=$(this).val();

    $('#students-section').html('<p>Loading students...</p>');

    $.get('/marks/classroom/'+classroomId+'/students',function(students){

        if(students.length===0){

            $('#students-section').html(
                '<div class="alert alert-warning">No students found.</div>'
            );

            return;

        }

        let html=`

        <table class="table table-bordered">

            <thead class="table-success">

                <tr>

                    <th>Admission No</th>

                    <th>Student Name</th>

                    <th width="180">Marks</th>

                </tr>

            </thead>

            <tbody>

        `;

        students.forEach(function(student){

            html += `

            <tr>

                <td>${student.admission_no}</td>

                <td>${student.first_name} ${student.last_name}</td>

                <td>

                    <input
                        type="number"
                        name="marks[${student.id}][score]"
                        class="form-control"
                        min="0"
                        max="100"
                        required>

                    <input
                        type="hidden"
                        name="marks[${student.id}][student_id]"
                        value="${student.id}">

                </td>

            </tr>

            `;

        });

        html +=`

            </tbody>

        </table>

        `;

        $('#students-section').html(html);

    });

});
</script>




@endsection