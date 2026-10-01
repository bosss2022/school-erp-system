@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Exam Results Report</h3>

    <form action="{{ route('results.show') }}" method="GET" class="card p-3 shadow-sm">
        <div class="row">
            <div class="col-md-5">
                <label class="form-label">Select Exam</label>
                <select name="exam_id" class="form-select" required>
                    <option value="">Choose Exam</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label class="form-label">Select Class</label>
                <select name="classroom_id" class="form-select" required>
                    <option value="">Choose Class</option>
                    @foreach($classes as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">View Report</button>
            </div>
        </div>
    </form>
</div>
@endsection
