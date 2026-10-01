@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Class Timetables</h3>

    <form action="{{ route('timetables.auto-generate') }}" method="GET" class="mb-4">
        @csrf
        
    @if(auth()->user() && auth()->user()->role === 'admin')
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-sync"></i> Auto Generate Timetable
        </button>
    @endif
        <a href="{{ route('timetables.download-pdf') }}" class="btn btn-danger ms-2">
            <i class="fa fa-file-pdf"></i> Download PDF
        </a>
    </form>

    @if($timetables->isEmpty())
        <div class="alert alert-info">No timetable generated yet.</div>
    @else
        @foreach($timetables as $classroomId => $classTimetables)
            @php $classroom = $classTimetables->first()->classroom; @endphp
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <strong>{{ $classroom->name }}</strong>
                </div>
                <div class="card-body">
                   
            <table class="table table-bordered table-hover text-center align-middle">

               <thead class="table-secondary">
                    <tr>
                        <th style="width:120px;">Day</th>

                        @foreach($timeSlots as $slot)
                            <th>{{ $slot }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>

                    @foreach($days as $day)

                        <tr>

                            <td class="fw-bold bg-light">
                                {{ $day }}
                            </td>

                            @foreach($timeSlots as $slot)

                                <td>

                                    @if(isset($grouped[$classroomId][$day][$slot]))

                                        @php
                                            $entry = $grouped[$classroomId][$day][$slot];
                                        @endphp

                                        @if($entry->is_break)

                                            <span class="badge bg-warning text-dark p-2">
                                                {{ $entry->label }}
                                            </span>

                                        @else

                                            <div class="fw-bold text-primary">
                                                {{ $entry->subject->name ?? 'Break' }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $entry->teacher
                                                    ? $entry->teacher->first_name . ' ' . $entry->teacher->last_name
                                                    : '-' }}
                                            </small>

                                        @endif

                                    @else
                                       -
                                    @endif

                                </td>

                            @endforeach

                        </tr>

                    @endforeach

                </tbody>

            </table>

                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
