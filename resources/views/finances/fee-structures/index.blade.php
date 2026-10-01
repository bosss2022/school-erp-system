@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-3">

        Fee Structures

    </h2>

    <!-- Search -->

    <form method="GET"
          action="{{ route('fee-structures.index') }}"
          class="mb-3">

        <div class="input-group">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search class, academic year or term"
                   value="{{ request('search') }}">

            <button class="btn btn-primary">

                Search

            </button>

        </div>

    </form>

    @if(auth()->user()->role == 'admin')

        <a href="{{ route('fee-structures.create') }}"
           class="btn btn-success mb-3">

            Add Fee Structure

        </a>

    @endif

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

        <tr>

            <th>#</th>

            <th>Class</th>

            <th>Academic Year</th>

            <th>Term</th>

            <th>Amount</th>

            <th width="180">

                Actions

            </th>

        </tr>

        </thead>

        <tbody>

        @forelse($feeStructures as $fee)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $fee->classroom->name }}</td>

                <td>{{ $fee->academicYear->name }}</td>

                <td>{{ $fee->term }}</td>

                <td>

                    Ksh {{ number_format($fee->amount,2) }}

                </td>

                <td>

                    <a href="{{ route('fee-structures.edit',$fee->id) }}"
                       class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <form action="{{ route('fee-structures.destroy',$fee->id) }}"
                          method="POST"
                          class="d-inline">

                        @csrf

                        @method('DELETE')

                        <button
                            onclick="return confirm('Delete this Fee Structure?')"
                            class="btn btn-danger btn-sm">

                            Delete

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="6"
                    class="text-center">

                    No Fee Structures Found

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    {{ $feeStructures->links() }}

</div>

@endsection