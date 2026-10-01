@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white d-flex justify-content-between">

            <h3 class="mb-0">

                Student Report Card

            </h3>

            <a href="{{ route('report-card.download',$student->id) }}"
               class="btn btn-light">

                <i class="fa fa-download"></i>

                Download PDF

            </a>

        </div>

        <div class="card-body">

            {{-- Student Details --}}

            <div class="row mb-4">

                <div class="col-md-3 text-center">

                    @if($student->photo)

                        <img src="{{ asset('storage/'.$student->photo) }}"
                             class="img-thumbnail"
                             width="170">

                    @else

                        <img src="{{ asset('images/avatar.png') }}"
                             class="img-thumbnail"
                             width="170">

                    @endif

                </div>

                <div class="col-md-9">

                    <table class="table table-bordered">

                        <tr>

                            <th width="30%">Admission No</th>

                            <td>{{ $student->admission_no }}</td>

                        </tr>

                        <tr>

                            <th>Student Name</th>

                            <td>

                                {{ $student->first_name }}

                                {{ $student->last_name }}

                            </td>

                        </tr>

                        <tr>

                            <th>Class</th>

                            <td>

                                {{ $student->classroom->name }}

                            </td>

                        </tr>

                        <tr>

                            <th>Guardian</th>

                            <td>

                                @if($student->guardian)

                                    {{ $student->guardian->first_name }}

                                    {{ $student->guardian->last_name }}

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            {{-- Marks --}}

            <h4 class="mb-3">

                Subject Performance

            </h4>

            <table class="table table-striped table-bordered">

                <thead class="table-success">

                <tr>

                    <th>#</th>

                    <th>Subject</th>

                    <th>Exam</th>

                    <th>Marks</th>

                    <th>Grade</th>

                    <th>Remark</th>

                </tr>

                </thead>

                <tbody>

                @foreach($subjects as $subject)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $subject['subject'] }}</td>

                        <td>{{ $subject['exam'] }}</td>

                        <td>{{ $subject['marks'] }}</td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $subject['grade'] }}

                            </span>

                        </td>

                        <td>{{ $subject['remark'] }}</td>

                    </tr>

                @endforeach

                </tbody>

            </table>

            {{-- Summary --}}

            <div class="row mt-5">

                <div class="col-md-6">

                    <div class="card border-success">

                        <div class="card-header bg-success text-white">

                            Performance Summary

                        </div>

                        <div class="card-body">

                            <table class="table">

                                <tr>

                                    <th>Total Marks</th>

                                    <td>{{ $totalMarks }}</td>

                                </tr>

                                <tr>

                                    <th>Average</th>

                                    <td>{{ $average }}</td>

                                </tr>

                                <tr>

                                    <th>Grade</th>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ $overallGrade }}

                                        </span>

                                    </td>

                                </tr>

                                <tr>

                                    <th>Position</th>

                                    <td>

                                        {{ $position }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Remark</th>

                                    <td>

                                        {{ $overallRemark }}

                                    </td>

                                </tr>

                            </table>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="card border-primary">

                        <div class="card-header bg-primary text-white">

                            Teacher's Remarks

                        </div>

                        <div class="card-body">

                            <textarea
                                class="form-control"
                                rows="5"
                                readonly>

{{ $overallRemark }}

                            </textarea>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection