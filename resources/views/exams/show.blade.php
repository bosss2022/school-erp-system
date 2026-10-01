@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Exam Details</h3>
    <div class="card mb-4">
        <div class="card-body">
            <h5>{{ $exam->name }}</h5>
            <p><strong>Term:</strong> {{ $exam->term ?? '—' }}</p>
            <p><strong>Date:</strong> {{ $exam->exam_date ?? '—' }}</p>
        </div>
    </div>
    <a href="{{ route('exams.index') }}" class="btn btn-secondary">Back to Exams</a>
</div>
@endsection
