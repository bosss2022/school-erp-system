
@extends('layouts.app')

@section('content')

<div class="container-fluid py-5 bg-light min-vh-100">

    <div class="container">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <div>

                <h1 class="fw-bold text-dark mb-2">
                    Mark Attendance
                </h1>

                <p class="text-muted mb-0">
                    {{ $classroom->name }} |
                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                </p>

            </div>

            <a href="{{ route('attendances.index') }}"
               class="btn btn-dark px-4 py-2 shadow-sm">

                <i class="fa-solid fa-arrow-left me-2"></i>
                Back

            </a>

        </div>


        {{-- FORM --}}
        <form action="{{ route('attendances.store') }}"
              method="POST">

            @csrf

            <input type="hidden"
                   name="classroom_id"
                   value="{{ $classroom->id }}">

            <input type="hidden"
                   name="date"
                   value="{{ $date }}">


            <div class="card border-0 shadow-lg rounded-4">

                <div class="card-header bg-primary text-white py-3 rounded-top-4">

                    <h5 class="mb-0 fw-semibold">
                        Attendance Register
                    </h5>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            {{-- HEAD --}}
                            <thead class="table-primary">

                                <tr>

                                    <th class="px-4 py-3">
                                        #
                                    </th>

                                    <th class="px-4 py-3">
                                        Student
                                    </th>

                                    <th class="px-4 py-3">
                                        Admission No
                                    </th>

                                    <th class="px-4 py-3 text-center">
                                        Attendance Status
                                    </th>

                                    <th class="px-4 py-3">
                                        Remarks
                                    </th>

                                </tr>

                            </thead>


                            {{-- BODY --}}
                            <tbody>

                                @foreach($students as $student)

                                    <tr>

                                        {{-- NUMBER --}}
                                        <td class="px-4 py-3 fw-semibold text-muted">

                                            {{ $loop->iteration }}

                                        </td>


                                        {{-- STUDENT --}}
                                        <td class="px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                                     style="width:45px; height:45px;">

                                                    {{ strtoupper(substr($student->first_name, 0, 1)) }}

                                                </div>

                                                <div>

                                                    <div class="fw-semibold text-dark">

                                                        {{ $student->first_name }}
                                                        {{ $student->last_name }}

                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- ADM --}}
                                        <td class="px-4 py-3 fw-medium text-secondary">

                                            {{ $student->admission_no }}

                                        </td>


                                        {{-- STATUS --}}
                                        <td class="px-4 py-3">

                                            <input type="hidden"
                                                   name="attendance[{{ $student->id }}][student_id]"
                                                   value="{{ $student->id }}">

                                            <div class="d-flex flex-wrap justify-content-center gap-3">

                                                <div class="form-check">

                                                    <input class="form-check-input"
                                                           type="radio"
                                                           name="attendance[{{ $student->id }}][status]"
                                                           value="present"
                                                           checked>

                                                    <label class="form-check-label text-success fw-semibold">

                                                        Present

                                                    </label>

                                                </div>


                                                <div class="form-check">

                                                    <input class="form-check-input"
                                                           type="radio"
                                                           name="attendance[{{ $student->id }}][status]"
                                                           value="absent">

                                                    <label class="form-check-label text-danger fw-semibold">

                                                        Absent

                                                    </label>

                                                </div>


                                                <div class="form-check">

                                                    <input class="form-check-input"
                                                           type="radio"
                                                           name="attendance[{{ $student->id }}][status]"
                                                           value="late">

                                                    <label class="form-check-label text-warning fw-semibold">

                                                        Late

                                                    </label>

                                                </div>


                                                <div class="form-check">

                                                    <input class="form-check-input"
                                                           type="radio"
                                                           name="attendance[{{ $student->id }}][status]"
                                                           value="permission">

                                                    <label class="form-check-label text-primary fw-semibold">

                                                        Permission

                                                    </label>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- REMARKS --}}
                                        <td class="px-4 py-3">

                                            <input type="text"
                                                   name="attendance[{{ $student->id }}][remarks]"
                                                   placeholder="Optional remarks"
                                                   class="form-control rounded-3">

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="mt-4">

                <button type="submit"
                        class="btn btn-primary btn-lg w-100 shadow-sm rounded-3">

                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    Save Attendance

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
