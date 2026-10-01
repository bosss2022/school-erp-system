@extends('layouts.app')

@section('title', 'Teacher Profile')

@section('content')

<div class="container py-4">

    <!-- Teacher Profile -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-2 text-center">

                    @if($teacher->photo)
                        <img src="{{ asset('storage/'.$teacher->photo) }}"
                             class="rounded-circle shadow"
                             width="120"
                             height="120"
                             alt="Teacher Photo">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}"
                             class="rounded-circle shadow"
                             width="120"
                             height="120"
                             alt="Teacher Photo">
                    @endif

                </div>

                <div class="col-md-7">

                    <h3 class="mb-1">
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </h3>

                    <p class="text-muted mb-2">
                        Teacher Profile
                    </p>

                    <div class="row">

                        <div class="col-md-6">
                            <strong>Email</strong><br>
                            {{ $teacher->email }}
                        </div>

                        <div class="col-md-6">
                            <strong>Phone</strong><br>
                            {{ $teacher->phone }}
                        </div>

                        <div class="col-md-6 mt-3">
                            <strong>Gender</strong><br>
                            {{ ucfirst($teacher->gender) }}
                        </div>

                        

                    </div>

                </div>

              
            </div>

        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h2>{{ $teacher->subjects->count() }}</h2>
                    <small class="text-muted">Subjects</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h2>{{ $teacher->classrooms->count() }}</h2>
                    <small class="text-muted">Classes</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h2>
                        {{ $teacher->classrooms->sum(fn($classroom) => $classroom->students->count()) }}
                    </h2>
                    <small class="text-muted">Students</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h2>{{ now()->year }}</h2>
                    <small class="text-muted">Academic Year</small>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <!-- Subjects -->
        <div class="col-lg-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        Subjects
                    </h5>
                </div>

                <div class="card-body">

                    @forelse($teacher->subjects as $subject)

                        <span class="badge bg-primary mb-2">
                            {{ $subject->name }}
                        </span>

                    @empty

                        <p class="text-muted">
                            No subjects assigned.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

        <!-- Classes -->
        <div class="col-lg-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        Classes
                    </h5>
                </div>

                <div class="card-body">

                    @forelse($teacher->classrooms as $classroom)

                        <div class="border rounded p-2 mb-2">

                            <strong>{{ $classroom->name }}</strong>

                            <br>

                            Students:
                            {{ $classroom->students->count() }}

                        </div>

                    @empty

                        <p class="text-muted">
                            No classes assigned.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

        <!-- Salary -->
        <div class="col-lg-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header bg-warning">
                    <h5 class="mb-0">
                        Salary Information
                    </h5>
                </div>

                <div class="card-body">

                    @if($teacher->salary)

                        <table class="table table-sm">

                            <tr>
                                <th>Amount</th>
                                <td>Ksh {{ number_format($teacher->salary->amount,2) }}</td>
                            </tr>

                            <tr>
                                <th>Month</th>
                                <td>{{ $teacher->salary->month }}</td>
                            </tr>

                            <tr>
                                <th>Year</th>
                                <td>{{ $teacher->salary->year }}</td>
                            </tr>

                            <tr>
                                <th>Payment Date</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($teacher->salary->payment_date)->format('d M Y') }}
                                </td>
                            </tr>

                        </table>

                    @else

                        <div class="alert alert-warning mb-0">
                            No salary record found.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <!-- Quick Actions -->
    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                Quick Actions
            </h5>
        </div>

        <div class="card-body">

            <div class="row g-3">

              
                <div class="col-md-3">
                    <a href="{{ route('marks.index') }}"
                       class="btn btn-outline-success w-100">
                        <i class="fa fa-pen"></i><br>
                        Enter Marks
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('revision-materials.index') }}"
                       class="btn btn-outline-warning w-100">
                        <i class="fa fa-book"></i><br>
                        Revision Materials
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('timetables.index') }}"
                       class="btn btn-outline-info w-100">
                        <i class="fa fa-clock"></i><br>
                        Timetable
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection