@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">

            <div class="d-flex justify-content-between">

                <h4 class="mb-0">

                    <i class="fa-solid fa-handshake me-2"></i>

                    {{ $meeting->title }}

                </h4>

                <a href="{{ route('meetings.index') }}"
                   class="btn btn-light btn-sm">

                    Back

                </a>

            </div>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <p>
                        <strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d M Y') }}
                    </p>

                    <p>
                        <strong>Time:</strong>
                        {{ \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') }}
                    </p>

                    <p>
                        <strong>Venue:</strong>
                        {{ $meeting->venue }}
                    </p>

                </div>

                <div class="col-md-6">

                    <p>
                        <strong>Target:</strong>

                        @if($meeting->target_type == 'all')

                            <span class="badge bg-primary">
                                All Guardians
                            </span>

                        @elseif($meeting->target_type == 'class')

                            <span class="badge bg-success">
                                Class Meeting
                            </span>

                        @else

                            <span class="badge bg-warning">
                                Individual Meeting
                            </span>

                        @endif

                    </p>

                </div>

            </div>

            <hr>

            <h5>Agenda</h5>

            <div class="alert alert-light">

                {{ $meeting->agenda ?? 'No agenda provided.' }}

            </div>

        </div>

    </div>

    {{-- Guardians --}}

    <div class="card shadow border-0 mt-4">

        <div class="card-header bg-dark text-white">

            Guardians Invited

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Attendance</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($meeting->guardians as $guardian)

                            <tr>

                                <td>

                                    {{ $guardian->first_name }}
                                    {{ $guardian->last_name }}

                                </td>

                                <td>

                                    {{ $guardian->email }}

                                </td>

                                <td>

                                    @if($guardian->pivot->attendance == 'present')

                                        <span class="badge bg-success">
                                            Present
                                        </span>

                                    @elseif($guardian->pivot->attendance == 'absent')

                                        <span class="badge bg-danger">
                                            Absent
                                        </span>

                                    @else

                                        <span class="badge bg-warning">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection