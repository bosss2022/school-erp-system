@extends('layouts.app')

@section('title', 'Mark Details')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">

                <i class="fa-solid fa-file-lines me-2"></i>

                Mark Details

            </h4>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>
                            <th width="40%">Student</th>
                            <td>
                                {{ $mark->student->first_name }}
                                {{ $mark->student->last_name }}
                            </td>
                        </tr>

                        <tr>
                            <th>Admission No</th>
                            <td>
                                {{ $mark->student->admission_no }}
                            </td>
                        </tr>

                        <tr>
                            <th>Class</th>
                            <td>
                                {{ $mark->student->classroom->name ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Subject</th>
                            <td>
                                {{ $mark->subject->name }}
                            </td>
                        </tr>

                    </table>

                </div>

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>
                            <th width="40%">Academic Year</th>
                            <td>
                                {{ $mark->exam->academicYear->name ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Term</th>
                            <td>
                                {{ $mark->exam->term }}
                            </td>
                        </tr>

                        <tr>
                            <th>Exam</th>
                            <td>
                                {{ $mark->exam->name }}
                            </td>
                        </tr>

                        <tr>
                            <th>Exam Date</th>
                            <td>
                                {{ $mark->exam->exam_date }}
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

            <hr>

            <div class="row text-center">

                <div class="col-md-6">

                    <div class="card border-primary">

                        <div class="card-body">

                            <h6 class="text-muted">

                                Marks Obtained

                            </h6>

                            <h1 class="text-primary">

                                {{ $mark->marks }}

                            </h1>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="card border-success">

                        <div class="card-body">

                            <h6 class="text-muted">

                                Grade

                            </h6>

                            <h1 class="text-success">

                                {{ $mark->grade }}

                            </h1>

                        </div>

                    </div>

                </div>

            </div>

            <div class="mt-4">

                <a href="{{ route('marks.edit', $mark) }}"
                   class="btn btn-warning">

                    <i class="fa-solid fa-pen-to-square me-2"></i>

                    Edit

                </a>

                <a href="{{ route('marks.index') }}"
                   class="btn btn-secondary">

                    <i class="fa-solid fa-arrow-left me-2"></i>

                    Back

                </a>

            </div>

        </div>

    </div>

</div>

@endsection