
@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h1 class="fw-bold text-dark mb-1">
                        Edit Attendance
                    </h1>

                    <p class="text-muted mb-0">
                        Update attendance information
                    </p>

                </div>

                <a href="{{ route('attendances.index') }}"
                   class="btn btn-dark px-4">

                    Back

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


            {{-- CARD --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- TOP --}}
                <div class="bg-primary text-white p-4">

                    <h2 class="fw-bold mb-1">

                        {{ $attendance->student->first_name }}
                        {{ $attendance->student->last_name }}

                    </h2>

                    <p class="mb-0">

                        {{ $attendance->classroom->name }}

                    </p>

                </div>


                {{-- FORM --}}
                <form action="{{ route('attendances.update', $attendance->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="card-body p-4">

                        {{-- DATE --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Attendance Date
                            </label>

                            <input type="date"
                                   value="{{ $attendance->date }}"
                                   disabled
                                   class="form-control bg-light">

                        </div>


                        {{-- STATUS --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold mb-3">
                                Attendance Status
                            </label>

                            <div class="row g-3">

                                {{-- PRESENT --}}
                                <div class="col-md-3 col-6">

                                    <input type="radio"
                                           class="btn-check"
                                           name="status"
                                           id="present"
                                           value="present"
                                           {{ $attendance->status == 'present' ? 'checked' : '' }}>

                                    <label class="btn btn-outline-success w-100 py-3"
                                           for="present">

                                        Present

                                    </label>

                                </div>


                                {{-- ABSENT --}}
                                <div class="col-md-3 col-6">

                                    <input type="radio"
                                           class="btn-check"
                                           name="status"
                                           id="absent"
                                           value="absent"
                                           {{ $attendance->status == 'absent' ? 'checked' : '' }}>

                                    <label class="btn btn-outline-danger w-100 py-3"
                                           for="absent">

                                        Absent

                                    </label>

                                </div>


                                {{-- LATE --}}
                                <div class="col-md-3 col-6">

                                    <input type="radio"
                                           class="btn-check"
                                           name="status"
                                           id="late"
                                           value="late"
                                           {{ $attendance->status == 'late' ? 'checked' : '' }}>

                                    <label class="btn btn-outline-warning w-100 py-3"
                                           for="late">

                                        Late

                                    </label>

                                </div>


                                {{-- PERMISSION --}}
                                <div class="col-md-3 col-6">

                                    <input type="radio"
                                           class="btn-check"
                                           name="status"
                                           id="permission"
                                           value="permission"
                                           {{ $attendance->status == 'permission' ? 'checked' : '' }}>

                                    <label class="btn btn-outline-primary w-100 py-3"
                                           for="permission">

                                        Permission

                                    </label>

                                </div>

                            </div>

                        </div>


                        {{-- REMARKS --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Remarks
                            </label>

                            <textarea name="remarks"
                                      rows="5"
                                      placeholder="Optional remarks..."
                                      class="form-control">{{ $attendance->remarks }}</textarea>

                        </div>


                        {{-- BUTTON --}}
                        <div>

                            <button type="submit"
                                    class="btn btn-primary w-100 py-3 fw-bold">

                                Update Attendance

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection
