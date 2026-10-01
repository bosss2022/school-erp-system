
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4 bg-light min-vh-100">

    <div class="container">

        {{-- HEADER --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                    <div>

                        <h1 class="fw-bold text-dark mb-1">
                            Attendance Records
                        </h1>

                        <p class="text-muted mb-0">
                            Manage and monitor student attendance records
                        </p>

                    </div>

                    <a href="{{ route('attendances.create') }}"
                       class="btn btn-primary px-4 py-2 fw-semibold">

                        <i class="fa-solid fa-plus me-2"></i>

                        Take Attendance

                    </a>

                </div>

            </div>

        </div>


        {{-- SUCCESS ALERT --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4"
                 role="alert">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"></button>

            </div>

        @endif


        {{-- FILTER CARD --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <h5 class="fw-semibold mb-4">
                    Filter Attendance
                </h5>

                <form method="GET"
                      action="{{ route('attendances.index') }}">

                    <div class="row g-3">

                        {{-- CLASSROOM --}}
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                Classroom
                            </label>

                            <select name="classroom_id"
                                    class="form-select">

                                <option value="">
                                    All Classrooms
                                </option>

                                @foreach($classrooms as $classroom)

                                    <option value="{{ $classroom->id }}"
                                        {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>

                                        {{ $classroom->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- DATE --}}
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                Date
                            </label>

                            <input type="date"
                                   name="date"
                                   value="{{ request('date') }}"
                                   class="form-control">

                        </div>


                        {{-- BUTTON --}}
                        <div class="col-md-4 d-flex align-items-end">

                            <button type="submit"
                                    class="btn btn-dark w-100 fw-semibold">

                                <i class="fa-solid fa-filter me-2"></i>

                                Filter Records

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- TABLE CARD --}}
        <div class="card shadow-sm border-0">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        {{-- TABLE HEAD --}}
                        <thead class="table-dark">

                            <tr>

                                <th class="px-4 py-3">
                                    Student
                                </th>

                                <th class="px-4 py-3">
                                    Classroom
                                </th>

                                <th class="px-4 py-3">
                                    Date
                                </th>

                                <th class="px-4 py-3">
                                    Status
                                </th>

                                <th class="px-4 py-3">
                                    Remarks
                                </th>

                                <th class="px-4 py-3 text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        {{-- TABLE BODY --}}
                        <tbody>

                            @forelse($attendances as $attendance)

                                <tr>

                                    {{-- STUDENT --}}
                                    <td class="px-4 py-3 fw-semibold text-dark">

                                        {{ $attendance->student->first_name }}
                                        {{ $attendance->student->last_name }}

                                    </td>


                                    {{-- CLASSROOM --}}
                                    <td class="px-4 py-3">

                                        {{ $attendance->classroom->name }}

                                    </td>


                                    {{-- DATE --}}
                                    <td class="px-4 py-3">

                                        {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}

                                    </td>


                                    {{-- STATUS --}}
                                    <td class="px-4 py-3">

                                        @if($attendance->status == 'present')

                                            <span class="badge bg-success px-3 py-2">
                                                Present
                                            </span>

                                        @elseif($attendance->status == 'absent')

                                            <span class="badge bg-danger px-3 py-2">
                                                Absent
                                            </span>

                                        @elseif($attendance->status == 'late')

                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                Late
                                            </span>

                                        @else

                                            <span class="badge bg-primary px-3 py-2">
                                                Permission
                                            </span>

                                        @endif

                                    </td>


                                    {{-- REMARKS --}}
                                    <td class="px-4 py-3 text-muted">

                                        {{ $attendance->remarks ?? '-' }}

                                    </td>


                                    {{-- ACTIONS --}}
                                    <td class="px-4 py-3">

                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('attendances.edit', $attendance->id) }}"
                                               class="btn btn-warning btn-sm text-white">

                                                <i class="fa-solid fa-pen-to-square me-1"></i>

                                                Edit

                                            </a>


                                            <form action="{{ route('attendances.destroy', $attendance->id) }}"
                                                  method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        onclick="return confirm('Delete this attendance record?')"
                                                        class="btn btn-danger btn-sm">

                                                    <i class="fa-solid fa-trash me-1"></i>

                                                    Delete

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="text-center py-5 text-muted">

                                        No attendance records found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- PAGINATION --}}
        <div class="mt-4">

            {{ $attendances->links() }}

        </div>

    </div>

</div>

@endsection

