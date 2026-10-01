@extends('layouts.app')

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-3">

<h3>

Fee Structure Documents

</h3>

<a

href="{{ route('fee-structure-documents.create') }}"

class="btn btn-success">

Upload PDF

</a>

</div>

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>#</th>

<th>Academic Year</th>

<th>File</th>

<th width="220">

Actions

</th>

</tr>

</thead>

<tbody>

@forelse($documents as $document)

<tr>

<td>

{{ $loop->iteration }}

</td>

<td>

{{ $document->academicYear->name }}

</td>

<td>

{{ basename($document->file) }}

</td>

<td>

<a

href="{{ route('fee-structure-documents.download',$document) }}"

class="btn btn-success btn-sm">

Download

</a>

<form

action="{{ route('fee-structure-documents.destroy',$document) }}"

method="POST"

style="display:inline;">

@csrf

@method('DELETE')

<button

class="btn btn-danger btn-sm"

onclick="return confirm('Delete this document?')">

Delete

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="4"

class="text-center">

No documents uploaded.

</td>

</tr>

@endforelse

</tbody>

</table>

{{ $documents->links() }}

</div>

@endsection