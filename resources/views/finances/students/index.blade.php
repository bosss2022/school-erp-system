@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-3">Student Payments</h2>

  <!-- 🔍 Search Form -->
  <form method="GET" action="{{ route('student-payments.index') }}" class="mb-3">
      <div class="input-group">
          <input type="text"
                 name="search"
                 class="form-control"
                 placeholder="Search by student name, admission no, or term"
                 value="{{ request('search') }}">
          <button class="btn btn-primary" type="submit">Search</button>
      </div>
  </form>
@if(auth()->user()->role === 'admin')
  <a href="{{ route('student-payments.create') }}" class="btn btn-success mb-3">Add Payment</a>
@endif
  <!-- 💰 Summary Card -->
  <div class="alert alert-info">
      <strong>Total Amount Paid:</strong> Ksh {{ number_format($totalPayments, 2) }}
  </div>

  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
<tr>

    <th>#</th>

    <th>Admission No</th>

    <th>Student</th>

    <th>Academic Year</th>

    <th>Term</th>

    <th>Amount Paid</th>

    <th>Total Fee</th>

    <th>Balance</th>

    <th>Date</th>

    <th width="220">Actions</th>

</tr>
</thead>
   <tbody>

@forelse($payments as $p)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $p->student->admission_no }}</td>

    <td>

        {{ $p->student->first_name }}

        {{ $p->student->last_name }}

    </td>

    <td>

        {{ $p->academicYear->name ?? '-' }}

    </td>

    <td>{{ $p->term }}</td>

    <td>

        Ksh {{ number_format($p->amount_paid,2) }}

    </td>

    <td>

        Ksh {{ number_format($p->total_fee,2) }}

    </td>

    <td>

        @if($p->balance > 0)

            <span class="badge bg-danger">

                Ksh {{ number_format($p->balance,2) }}

            </span>

        @else

            <span class="badge bg-success">

                Cleared

            </span>

        @endif

    </td>

    <td>

        {{ $p->payment_date->format('d M Y') }}

    </td>

    <td>

        <a href="{{ route('student-payments.download',$p->id) }}"
           class="btn btn-success btn-sm">

            <i class="fa fa-download"></i>

        </a>

        @if(auth()->user()->role=='admin')

        <a href="{{ route('student-payments.edit',$p->id) }}"
           class="btn btn-primary btn-sm">

            <i class="fa fa-edit"></i>

        </a>

        <form
            action="{{ route('student-payments.destroy',$p->id) }}"
            method="POST"
            class="d-inline">

            @csrf

            @method('DELETE')

            <button
                onclick="return confirm('Delete this payment?')"
                class="btn btn-danger btn-sm">

                <i class="fa fa-trash"></i>

            </button>

        </form>

        @endif

    </td>

</tr>

@empty

<tr>

    <td colspan="10" class="text-center">

        No payments found.

    </td>

</tr>

@endforelse

</tbody>
  </table>

  <!-- Pagination Links -->
  <div class="mt-3">
    {{ $payments->links() }}
  </div>
</div>
@endsection
