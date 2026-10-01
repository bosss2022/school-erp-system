@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>Upload Fee Structure PDF</h4>

</div>

<div class="card-body">

<form

action="{{ route('fee-structure-documents.store') }}"

method="POST"

enctype="multipart/form-data">

@csrf

<div class="mb-3">

<label>

Academic Year

</label>

<select

name="academic_year_id"

class="form-select"

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

Fee Structure PDF

</label>

<input

type="file"

name="file"

accept=".pdf"

class="form-control"

required>

</div>

<button

class="btn btn-success">

Upload PDF

</button>

</form>

</div>

</div>

</div>

@endsection