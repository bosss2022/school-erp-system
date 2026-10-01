@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-warning">

<h4>

Edit Fee Structure

</h4>

</div>

<div class="card-body">

<form action="{{ route('fee-structures.update',$feeStructure->id) }}"
      method="POST">

@csrf

@method('PUT')

<div class="mb-3">

<label>

Academic Year

</label>

<select name="academic_year_id"
        class="form-control">

@foreach($academicYears as $year)

<option value="{{ $year->id }}"
@if($feeStructure->academic_year_id==$year->id) selected @endif>

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
        class="form-control">

@foreach($classrooms as $class)

<option value="{{ $class->id }}"
@if($feeStructure->classroom_id==$class->id) selected @endif>

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

<option value="Term 1"
@if($feeStructure->term=="Term 1") selected @endif>

Term 1

</option>

<option value="Term 2"
@if($feeStructure->term=="Term 2") selected @endif>

Term 2

</option>

<option value="Term 3"
@if($feeStructure->term=="Term 3") selected @endif>

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
       class="form-control"
       name="amount"
       value="{{ $feeStructure->amount }}">

</div>

<button class="btn btn-primary">

Update Fee Structure

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