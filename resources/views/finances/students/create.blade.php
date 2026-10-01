@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h4>Record Student Payment</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('student-payments.store') }}" method="POST">

                @csrf

                {{-- Student --}}
                <div class="mb-3">

                    <label class="form-label">Student</label>

                    <select name="student_id"
                            id="student_id"
                            class="form-select"
                            required>

                        <option value="">Select Student</option>

                        @foreach($students as $student)

                            <option value="{{ $student->id }}">

                                {{ $student->admission_no }}
                                -
                                {{ $student->first_name }}
                                {{ $student->last_name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Academic Year --}}
                <div class="mb-3">

                    <label class="form-label">

                        Academic Year

                    </label>

                    <select name="academic_year_id"
                            id="academic_year_id"
                            class="form-select"
                            required>

                        <option value="">

                            Select Academic Year

                        </option>

                        @foreach($academicYears as $year)

                            <option value="{{ $year->id }}">

                                {{ $year->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Term --}}
                <div class="mb-3">

                    <label class="form-label">

                        Term

                    </label>

                    <select name="term"
                            id="term"
                            class="form-select"
                            required>

                        <option value="">

                            Select Term

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

                   <div class="mb-3">

    <label class="form-label">

        Class

    </label>

    <select
        name="classroom_id"
        id="classroom_id"
        class="form-select"
        required>

        <option value="">Select Class</option>

        @foreach($classrooms as $class)

            <option value="{{ $class->id }}">

                {{ $class->name }}

            </option>

        @endforeach

    </select>

</div>

                </div>

                {{-- Fee Amount --}}
                <div class="mb-3">

                    <label>

                        Total Fee

                    </label>

                    <input
                        type="number"
                        name="total_fee"
                        id="total_fee"
                        class="form-control"
                        readonly>

                </div>

                {{-- Amount Paid --}}
                <div class="mb-3">

                    <label>

                        Amount Paid

                    </label>

                    <input
                        type="number"
                        name="amount_paid"
                        class="form-control"
                        required>

                </div>

                <button class="btn btn-success">

                    Record Payment

                </button>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
$(document).ready(function () {

    $('#student_id').select2({
        placeholder: "Search Student",
        allowClear: true
    });

    $('#academic_year_id, #term, #classroom_id').on('change', function () {

        let classroom = $('#classroom_id').val();
        let year = $('#academic_year_id').val();
        let term = $('#term').val();

        if (classroom && year && term) {

            $.ajax({
                url: "{{ route('fee-structure.load') }}",
                type: "GET",
                data: {
                    classroom_id: classroom,
                    academic_year_id: year,
                    term: term
                },
                success: function (response) {

                    $('#total_fee').val(response.amount);

                },
                error: function () {

                    $('#total_fee').val('');

                    alert('Unable to load fee structure.');

                }
            });

        } else {

            $('#total_fee').val('');

        }

    });

});
</script>

@endpush