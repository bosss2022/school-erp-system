
@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            {{-- HEADER --}}
            <div class="card border-0 shadow-lg mb-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow"
                             style="width: 80px; height: 80px; font-size: 30px;">

                            {{ strtoupper(substr($student->first_name, 0, 1)) }}

                        </div>

                        <div class="ms-4">

                            <h1 class="fw-bold mb-2">

                                My Attendance

                            </h1>

                            <p class="text-muted mb-1">

                                {{ $student->first_name }}
                                {{ $student->last_name }}

                            </p>

                            <small class="text-secondary">

                                Admission No:
                                {{ $student->admission_no }}

                            </small>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ATTENDANCE TABLE --}}
            <div class="card border-0 shadow-lg">

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            {{-- HEAD --}}
                            <thead class="table-primary">

                                <tr>

                                    <th class="px-4 py-3">
                                        Date
                                    </th>

                                    <th class="px-4 py-3">
                                        Status
                                    </th>

                                    <th class="px-4 py-3">
                                        Remarks
                                    </th>

                                </tr>

                            </thead>


                            {{-- BODY --}}
                            <tbody>

                                @forelse($attendances as $attendance)

                                    <tr>

                                        {{-- DATE --}}
                                        <td class="px-4 py-3 fw-semibold text-secondary">

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

                                                <span class="badge bg-info text-dark px-3 py-2">

                                                    Permission

                                                </span>

                                            @endif

                                        </td>


                                        {{-- REMARKS --}}
                                        <td class="px-4 py-3 text-muted">

                                            {{ $attendance->remarks ?? 'No remarks' }}

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="3" class="text-center py-5 text-muted">

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

</div>

@endsection
