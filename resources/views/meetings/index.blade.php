@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold text-dark">
                <i class="fa-solid fa-handshake text-primary me-2"></i>
                Guardian Meetings
            </h2>

            <p class="text-muted mb-0">
                Manage parent and guardian meetings
            </p>
        </div>

        <a href="{{ route('meetings.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus me-2"></i>

            Schedule Meeting
        </a>

    </div>


    {{-- Success Alert --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card border-0 shadow">

                <div class="card-body text-center">

                    <i class="fa-solid fa-calendar-days fa-2x text-primary mb-3"></i>

                    <h3>{{ $meetings->count() }}</h3>

                    <p class="text-muted mb-0">
                        Total Meetings
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Meetings Table --}}
    <div class="card border-0 shadow">

        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">

                Meeting Schedule

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Title</th>

                            <th>Date</th>

                            <th>Time</th>

                            <th>Venue</th>

                            <th>Target</th>

                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($meetings as $meeting)

                            <tr>

                                <td>
                                    <strong>
                                        {{ $meeting->title }}
                                    </strong>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d M Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') }}
                                </td>

                                <td>
                                    {{ $meeting->venue }}
                                </td>

                                <td>

                                    @if($meeting->target_type == 'all')

                                        <span class="badge bg-primary">
                                            All Guardians
                                        </span>

                                    @elseif($meeting->target_type == 'class')

                                        <span class="badge bg-success">
                                            Class Meeting
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            Individual
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('meetings.show',$meeting->id) }}"
                                       class="btn btn-sm btn-info">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>

                                    <a href="{{ route('meetings.edit',$meeting->id) }}"
                                       class="btn btn-sm btn-warning">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>

                                    <form action="{{ route('meetings.destroy',$meeting->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-4">

                                    No meetings scheduled.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $meetings->links() }}

            </div>

        </div>

    </div>

</div>

@endsection