@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Add Finance Record</h2>

  <form action="{{ route('finances.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label>Type</label>
      <select name="type" class="form-control" required>
        <option value="">Select Type</option>
        <option value="income">Income</option>
        <option value="expense">Expense</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Category</label>
      <input type="text" name="category" class="form-control" placeholder="e.g. Tuition, Salary">
    </div>

    <div class="mb-3">
      <label>Amount</label>
      <input type="number" step="0.01" name="amount" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Save</button>
  </form>
</div>
@endsection
