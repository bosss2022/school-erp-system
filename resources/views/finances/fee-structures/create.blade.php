@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>

Create Fee Structure

</h4>

</div>

<div class="card-body">

<form action="{{ route('fee-structures.store') }}"
      method="POST">

@csrf

<div class="mb-3">

<label>

Academic Year

</label>

<select name="academic_year_id"
        class="form-control"
        required>

<option value="">

Select Academic Year

</option>

@foreach($academicYears as $year)

<option value="{{ $year->id }}">

{{ $year->name }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>

Class

</label>

<select name="classroom_id"
        class="form-control"
        required>

<option value="">

Select Class

</option>

@foreach($classrooms as $class)

<option value="{{ $class->id }}">

{{ $class->name }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>

Term

</label>

<select name="term"
        class="form-control">

<option>

Term 1

</option>

<option>

Term 2

</option>

<option>

Term 3

</option>

</select>

</div>

<div class="mb-3">

<label>

Amount

</label>

<input type="number"
       step="0.01"
       name="amount"
       class="form-control"
       required>

</div>

<button class="btn btn-success">

Save Fee Structure

</button>

<a href="{{ route('fee-structures.index') }}"
   class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

@endsection