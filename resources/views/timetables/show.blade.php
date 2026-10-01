@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Timetable Details</h4>
    <p><strong>Classroom:</strong> {{ $timetable->classroom->name }}</p>
    <p><strong>Subject:</strong> {{ $timetable->subject->name }}</p>
    <p><strong>Teacher:</strong> {{ $timetable->teacher->first_name }} {{ $timetable->teacher->last_name }}</p>
    <p><strong>Day:</strong> {{ $timetable->day }}</p>
    <p><strong>Time:</strong> {{ $timetable->start_time }} - {{ $timetable->end_time }}</p>

    <a href="{{ route('timetables.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
