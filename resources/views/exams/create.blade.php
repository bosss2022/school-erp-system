@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">

                <i class="fa-solid fa-file-pen me-2"></i>

                Create Exam

            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('exams.store') }}" method="POST">

                @csrf

                <!-- Academic Year -->

                <div class="mb-3">

                    <label class="form-label">

                        Academic Year

                    </label>

                    <select
                        name="academic_year_id"
                        class="form-select"
                        required>

                        <option value="">

                            -- Select Academic Year --

                        </option>

                        @foreach($academicYears as $year)

                            <option
                                value="{{ $year->id }}"
                                {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>

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

                        <option value="">

                            -- Select Exam --
                            
                           
                        </option>

                        <option value="Opening Exam">

                            Opening Exam

                        </option>

                        <option value="Mid Exam">

                            Mid Exam

                        </option>

                        <option value="Test Exam">

                            Test Exam

                        </option>

                        <option value="End Exam">

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

                        <option value="">

                            -- Select Term --

                        </option>

                        <option value="Term 1">

                            Term 1

                        </option>

                        <option value="Term 2">

                            Term 2

                        </option>

                        <option value="Term 3">

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
                        value="{{ old('exam_date') }}"
                        required>

                </div>

                <button class="btn btn-success">

                    <i class="fa-solid fa-save me-2"></i>

                    Save Exam

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