@extends('layouts.app')

@section('title', 'Edit Exam')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">

            <h4 class="mb-0">

                <i class="fa-solid fa-pen-to-square me-2"></i>

                Edit Exam

            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('exams.update', $exam) }}" method="POST">

                @csrf
                @method('PUT')

                <!-- Academic Year -->

                <div class="mb-3">

                    <label class="form-label">

                        Academic Year

                    </label>

                    <select
                        name="academic_year_id"
                        class="form-select"
                        required>

                        @foreach($academicYears as $year)

                            <option
                                value="{{ $year->id }}"
                                {{ old('academic_year_id', $exam->academic_year_id) == $year->id ? 'selected' : '' }}>

                                {{ $year->name }}

                                @if($year->is_current)

                                    (Current)

                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Exam Name -->

                <div class="mb-3">

                    <label class="form-label">

                        Exam Name

                    </label>

                    <select
                        name="name"
                        class="form-select"
                        required>

                        <option value="Opening Exam"
                            {{ old('name', $exam->name) == 'Opening Exam' ? 'selected' : '' }}>

                            Opening Exam

                        </option>

                        <option value="Mid Exam"
                            {{ old('name', $exam->name) == 'Mid Exam' ? 'selected' : '' }}>

                            Mid Exam

                        </option>

                        <option value="Test Exam"
                            {{ old('name', $exam->name) == 'Test Exam' ? 'selected' : '' }}>

                            Test Exam

                        </option>

                        <option value="End Exam"
                            {{ old('name', $exam->name) == 'End Exam' ? 'selected' : '' }}>

                            End Exam

                        </option>

                    </select>

                </div>

                <!-- Term -->

                <div class="mb-3">

                    <label class="form-label">

                        Term

                    </label>

                    <select
                        name="term"
                        class="form-select"
                        required>

                        <option value="Term 1"
                            {{ old('term', $exam->term) == 'Term 1' ? 'selected' : '' }}>

                            Term 1

                        </option>

                        <option value="Term 2"
                            {{ old('term', $exam->term) == 'Term 2' ? 'selected' : '' }}>

                            Term 2

                        </option>

                        <option value="Term 3"
                            {{ old('term', $exam->term) == 'Term 3' ? 'selected' : '' }}>

                            Term 3

                        </option>

                    </select>

                </div>

                <!-- Exam Date -->

                <div class="mb-4">

                    <label class="form-label">

                        Exam Date

                    </label>

                    <input
                        type="date"
                        name="exam_date"
                        class="form-control"
                        value="{{ old('exam_date', $exam->exam_date?->format('Y-m-d')) }}"
                        required>

                </div>

                <button class="btn btn-warning">

                    <i class="fa-solid fa-save me-2"></i>

                    Update Exam

                </button>

                <a href="{{ route('exams.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection