@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Finance Records</h2>

  <a href="{{ route('finances.create') }}" class="btn btn-primary mb-3">Add New Record</a>
 
     <!-- Search Form -->
    <form action="{{ route('finances.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Search by type, category, description, or amount">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-search"></i> Search
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('finances.index') }}" class="btn btn-secondary w-100">
                <i class="fa fa-rotate-left"></i> Reset
            </a>
        </div>
    </form>


  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Type</th>
        <th>Category</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Recorded By</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($finances as $record)
      <tr>
        <td>{{ ucfirst($record->type) }}</td>
        <td>{{ $record->category }}</td>
        <td>Ksh {{ number_format($record->amount, 2) }}</td>
        <td>{{ $record->description }}</td>
        <td>{{ $record->user->name ?? 'System' }}</td>
        <td>{{ $record->created_at->format('Y-m-d') }}</td>
        <td>
          <form action="{{ route('finances.destroy', $record->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
