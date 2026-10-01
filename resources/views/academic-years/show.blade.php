@extends('layouts.app')

@section('title', 'Academic Year Details')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                <i class="fa-solid fa-calendar-days me-2"></i>

                Academic Year Details

            </h4>

            <a href="{{ route('academic-years.index') }}"
               class="btn btn-light btn-sm">

                <i class="fa-solid fa-arrow-left"></i>

                Back

            </a>

        </div>

        <div class="card-body">

            <div class="row">

                <!-- Academic Year Details -->

                <div class="col-lg-6">

                    <div class="card border-success mb-4">

                        <div class="card-header bg-light">

                            <strong>

                                <i class="fa-solid fa-circle-info me-2"></i>

                                Academic Year Information

                            </strong>

                        </div>

                        <div class="card-body">

                            <table class="table table-borderless">

                                <tr>

                                    <th width="35%">Academic Year</th>

                                    <td>{{ $academicYear->name }}</td>

                                </tr>

                                <tr>

                                    <th>Start Date</th>

                                    <td>

                                        {{ \Carbon\Carbon::parse($academicYear->start_date)->format('d M Y') }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>End Date</th>

                                    <td>

                                        {{ \Carbon\Carbon::parse($academicYear->end_date)->format('d M Y') }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Status</th>

                                    <td>

                                        @if($academicYear->is_current)

                                            <span class="badge bg-success">

                                                Current Academic Year

                                            </span>

                                        @else

                                            <span class="badge bg-secondary">

                                                Closed

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                                <tr>

                                    <th>Created</th>

                                    <td>

                                        {{ $academicYear->created_at->format('d M Y') }}

                                    </td>

                                </tr>

                            </table>

                        </div>

                    </div>

                </div>

                <!-- Statistics -->

                <div class="col-lg-6">

                    <div class="card border-primary mb-4">

                        <div class="card-header bg-light">

                            <strong>

                                <i class="fa-solid fa-chart-column me-2"></i>

                                Statistics

                            </strong>

                        </div>

                        <div class="card-body">

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <div class="border rounded p-3 text-center">

                                        <i class="fa-solid fa-file-lines fa-2x text-primary mb-2"></i>

                                        <h3>

                                            {{ $academicYear->exams->count() }}

                                        </h3>

                                        <small>Exams</small>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="border rounded p-3 text-center">

                                        <i class="fa-solid fa-book fa-2x text-success mb-2"></i>

                                        <h3>

                                            {{ $academicYear->exams->pluck('term')->unique()->count() }}

                                        </h3>

                                        <small>Terms</small>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Exams -->

            <div class="card mt-3">

                <div class="card-header bg-light">

                    <strong>

                        <i class="fa-solid fa-file-pen me-2"></i>

                        Exams in {{ $academicYear->name }}

                    </strong>

                </div>

                <div class="card-body">

                    @if($academicYear->exams->count())

                        <table class="table table-bordered table-hover">

                            <thead class="table-success">

                                <tr>

                                    <th>#</th>

                                    <th>Exam Name</th>

                                    <th>Term</th>

                                    <th>Exam Date</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($academicYear->exams as $exam)

                                    <tr>

                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $exam->name }}</td>

                                        <td>{{ $exam->term }}</td>

                                        <td>

                                            {{ \Carbon\Carbon::parse($exam->exam_date)->format('d M Y') }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="alert alert-warning mb-0">

                            No exams have been created for this Academic Year.

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection