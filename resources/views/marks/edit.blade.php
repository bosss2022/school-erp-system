@extends('layouts.app')

@section('title','Edit Mark')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h4 class="mb-0">

                <i class="fa-solid fa-pen-to-square me-2"></i>

                Edit Student Mark

            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('marks.update',$mark) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label>Academic Year</label>

                        <select
                            id="academic_year_id"
                            class="form-select"
                            required>

                            @foreach($academicYears as $year)

                                <option
                                    value="{{ $year->id }}"
                                    {{ $year->id == $mark->exam->academic_year_id ? 'selected' : '' }}>

                                    {{ $year->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label>Term</label>

                        <select
                            id="term"
                            class="form-select"
                            required>

                            <option selected>

                                {{ $mark->exam->term }}

                            </option>

                        </select>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label>Exam</label>

                        <select
                            id="exam_id"
                            name="exam_id"
                            class="form-select"
                            required>

                            <option
                                value="{{ $mark->exam->id }}"
                                selected>

                                {{ $mark->exam->name }}

                            </option>

                        </select>

                    </div>

                </div>


                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Classroom</label>

                        <select
                            id="classroom_id"
                            class="form-select">

                            @foreach($classrooms as $classroom)

                                <option
                                    value="{{ $classroom->id }}"
                                    {{ $classroom->id == $mark->student->classroom_id ? 'selected' : '' }}>

                                    {{ $classroom->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Subject</label>

                        <select
                            id="subject_id"
                            name="subject_id"
                            class="form-select"
                            required>

                            <option
                                value="{{ $mark->subject->id }}"
                                selected>

                                {{ $mark->subject->name }}

                            </option>

                        </select>

                    </div>

                </div>

                <hr>

                <table class="table table-bordered">

                    <thead class="table-light">

                        <tr>

                            <th>Admission No</th>

                            <th>Student</th>

                            <th width="200">Marks</th>

                        </tr>

                    </thead>

                    <tbody id="student-list">

                        <tr>

                            <td>

                                {{ $mark->student->admission_no }}

                            </td>

                            <td>

                                {{ $mark->student->first_name }}

                                {{ $mark->student->last_name }}

                            </td>

                            <td>

                                <input
                                    type="number"
                                    name="marks"
                                    class="form-control"
                                    value="{{ $mark->marks }}"
                                    min="0"
                                    max="100"
                                    required>

                                <input
                                    type="hidden"
                                    name="student_id"
                                    value="{{ $mark->student_id }}">

                            </td>

                        </tr>

                    </tbody>

                </table>

                <button class="btn btn-warning">

                    <i class="fa-solid fa-save me-2"></i>

                    Update Mark

                </button>

                <a href="{{ route('marks.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection