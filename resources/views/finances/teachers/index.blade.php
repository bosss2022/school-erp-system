@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-3">Teacher Salaries</h2>

  <!-- 🔍 Search Form -->
  <form method="GET" action="{{ route('teacher-salaries.index') }}" class="mb-3">
      <div class="input-group">
          <input type="text" 
                 name="search" 
                 class="form-control" 
                 placeholder="Search by teacher name, email, month, or year"
                 value="{{ request('search') }}">
          <button class="btn btn-primary" type="submit">Search</button>
      </div>
  </form>
   @if(auth()->user()->role === 'admin')

  <a href="{{ route('teacher-salaries.create') }}" class="btn btn-success mb-3">Add Salary</a>
  @endif
  <!-- 💰 Summary Card -->
  <div class="alert alert-info">
      <strong>Total Salaries Paid:</strong> Ksh {{ number_format($totalSalaries, 2) }}
  </div>

  <table class="table table-bordered table-striped align-middle">

    <thead class="table-dark">

    <tr>

        <th>#</th>
        <th>Teacher</th>
        <th>Amount</th>
        <th>Month</th>
        <th>Year</th>
        <th>Date Paid</th>
        <th width="250">Actions</th>

    </tr>

    </thead>

    <tbody>

    @forelse($salaries as $s)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>

            {{ $s->teacher->first_name ?? '' }}
            {{ $s->teacher->last_name ?? '' }}

            <br>

            <small class="text-muted">

                {{ $s->teacher->email ?? '' }}

            </small>

        </td>

        <td>

            Ksh {{ number_format($s->amount, 2) }}

        </td>

        <td>{{ $s->month }}</td>

        <td>{{ $s->year }}</td>

        <td>

            {{ $s->payment_date ? \Carbon\Carbon::parse($s->payment_date)->format('d M Y') : '-' }}

        </td>

        <td>

            <a href="{{ route('teacher-salaries.download', $s->id) }}"
               class="btn btn-success btn-sm">

                <i class="fa fa-file-pdf"></i>

                Download

            </a>

            @if(auth()->user()->role === 'admin')

               
                <form action="{{ route('teacher-salaries.destroy', $s->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this salary record?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm">

                        <i class="fa fa-trash"></i>

                        Delete

                    </button>

                </form>

            @endif

        </td>

    </tr>

    @empty

    <tr>

        <td colspan="7" class="text-center">

            No salary records found.

        </td>

    </tr>

    @endforelse

    </tbody>

</table>

  <!-- Pagination Links -->
  <div class="mt-3">
    {{ $salaries->links() }}
  </div>
</div>
@endsection
