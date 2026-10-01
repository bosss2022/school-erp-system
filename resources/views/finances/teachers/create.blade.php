@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Record Teacher Salary</h2>
  <form action="{{ route('teacher-salaries.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label>Teacher</label>
      <select name="teacher_id" class="form-control" required>
        <option value="">Select Teacher</option>
        @foreach($teachers as $teacher)
        <option value="{{ $teacher->id }}">
          {{ $teacher->first_name }} {{ $teacher->last_name }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label>Amount</label>
      <input type="number" name="amount" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Month</label>
      <select name="month" class="form-select" required>
    <option value="">-- Select Month --</option>
    <option value="January">January</option>
    <option value="February">February</option>
    <option value="March">March</option>
    <option value="April">April</option>
    <option value="May">May</option>
    <option value="June">June</option>
    <option value="July">July</option>
    <option value="August">August</option>
    <option value="September">September</option>
    <option value="October">October</option>
    <option value="November">November</option>
    <option value="December">December</option>
</select>

    </div>

    <div class="mb-3">
      <label>Year</label>
      <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
    </div>

    <button class="btn btn-success">Record Salary</button>
  </form>
</div>

  <script>
$(document).ready(function() {
    $('select[name="teacher_id"]').select2({
        placeholder: "Search or select a teacher",
        allowClear: true
    });
});
</script>
 
@endsection
