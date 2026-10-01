@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                <i class="fa-solid fa-users-viewfinder text-primary me-2"></i>
                Promote Students
            </h3>

            <p class="text-muted mb-0">
                Select students and choose the class to promote them to.
            </p>

        </div>

        <a href="{{ route('promotions.history') }}"
           class="btn btn-dark">

            <i class="fa-solid fa-clock-rotate-left me-2"></i>

            Promotion History

        </a>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- PROMOTION CARD --}}
    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-header bg-primary text-white py-3">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h5 class="mb-0">

                        Current Class:
                        <strong>{{ $classroom->name }}</strong>

                    </h5>

                </div>

                <div class="col-md-6">

                    <label class="form-label mb-1">

                        Promote To

                    </label>

                    <select
                        name="to_classroom_id"
                        class="form-select"
                        form="promotionForm"
                        required>

                        <option value="">

                            Select Destination Class

                        </option>

                        @foreach($classrooms as $class)

                            <option value="{{ $class->id }}">

                                {{ $class->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>


        <div class="card-body">

            <form id="promotionForm"
                  action="{{ route('promotions.promote') }}"
                  method="POST">

                @csrf

                <input
                    type="hidden"
                    name="from_classroom_id"
                    value="{{ $classroom->id }}">

                <input
                    type="hidden"
                    name="current_year"
                    value="{{ $currentYear }}">

                <input
                    type="hidden"
                    name="new_year"
                    value="{{ $currentYear + 1 }}">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th width="50">

                                    <input
                                        type="checkbox"
                                        id="selectAll">

                                </th>

                                <th>Admission No</th>

                                <th>Student Name</th>

                                <th>Gender</th>

                                <th>Current Class</th>

                                <th>Academic Year</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($students as $student)

                                <tr>

                                    <td>

                                        <input
                                            type="checkbox"
                                            name="student_ids[]"
                                            value="{{ $student->id }}"
                                            class="studentCheckbox">

                                    </td>

                                    <td>

                                        <span class="badge bg-secondary">

                                            {{ $student->admission_no }}

                                        </span>

                                    </td>

                                    <td class="fw-semibold">

                                        {{ $student->first_name }}
                                        {{ $student->last_name }}

                                    </td>

                                    <td>

                                        @if($student->gender == 'Male')

                                            <span class="badge bg-primary">

                                                Male

                                            </span>

                                        @else

                                            <span class="badge bg-danger">

                                                Female

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        {{ $classroom->name }}

                                    </td>

                                    <td>

                                        {{ $student->academic_year }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="text-center py-5">

                                        No students found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if($students->count())

                    <div class="text-end mt-4">

                        <button
                            type="submit"
                            class="btn btn-success btn-lg">

                            <i class="fa-solid fa-arrow-up-right-dots me-2"></i>

                            Promote Selected Students

                        </button>

                    </div>

                @endif

            </form>

        </div>

    </div>

</div>

<script>

document.getElementById('selectAll').addEventListener('change', function () {

    document.querySelectorAll('.studentCheckbox').forEach(function (checkbox) {

        checkbox.checked = document.getElementById('selectAll').checked;

    });

});

</script>

@endsection