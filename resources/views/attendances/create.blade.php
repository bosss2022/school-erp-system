
@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            {{-- PAGE HEADER --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

                <div>

                    <h1 class="fw-bold text-dark">
                        Take Attendance
                    </h1>

                    <p class="text-muted mb-0">
                        Record daily student attendance
                    </p>

                </div>

                <a href="{{ route('attendances.index') }}"
                   class="btn btn-dark mt-3 mt-md-0 px-4 py-2">

                    Back to Records

                </a>

            </div>


            {{-- ERROR ALERT --}}
            @if ($errors->any())

                <div class="alert alert-danger shadow-sm">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORM CARD --}}
            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-body p-4 p-md-5">

                    <form action="{{ route('attendances.loadStudents') }}"
                          method="POST">

                        @csrf

                        <div class="row g-4">

                            {{-- CLASSROOM --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Select Classroom
                                </label>

                                <select name="classroom_id"
                                        required
                                        class="form-select form-select-lg">

                                    <option value="">
                                        Choose Classroom
                                    </option>

                                    @foreach($classrooms as $classroom)

                                        <option value="{{ $classroom->id }}">

                                            {{ $classroom->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- DATE --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Attendance Date
                                </label>

                                <input type="date"
                                       name="date"
                                       value="{{ date('Y-m-d') }}"
                                       required
                                       class="form-control form-control-lg">

                            </div>

                        </div>


                        {{-- BUTTON --}}
                        <div class="mt-5">

                            <button type="submit"
                                    class="btn btn-primary btn-lg w-100">

                                Load Students

                            </button>

                        </div>

                    </form>

                </div>

            </div>


            {{-- INFO CARD --}}
            <div class="card shadow-sm border-0 rounded-4 mt-4">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center me-3"
                             style="width:60px; height:60px;">

                            <i class="fa-solid fa-user-check fs-3"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">
                                Attendance Tips
                            </h5>

                            <p class="text-muted mb-0">
                                Select a classroom and date to begin recording attendance.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

