@extends('layouts.app')

@section('title','Marks Management')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>

            <i class="fa-solid fa-square-poll-vertical me-2"></i>

            Marks Management

        </h3>

        <a href="{{ route('marks.create') }}" class="btn btn-success">

            <i class="fa-solid fa-plus me-2"></i>

            Record Marks

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    <form action="{{ route('marks.index') }}" method="GET">

        <div class="row mb-4">

            <div class="col-md-3">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Search Student, Subject or Exam">

            </div>

            <div class="col-md-2">

                <button class="btn btn-primary w-100">

                    <i class="fa fa-search"></i>

                    Search

                </button>

            </div>

            <div class="col-md-2">

                <a href="{{ route('marks.index') }}"
                   class="btn btn-secondary w-100">

                    Reset

                </a>

            </div>

        </div>

    </form>


    <div class="card shadow">

        <div class="table-responsive">

            <table class="table table-hover table-bordered mb-0">

                <thead class="table-success">

                    <tr>

                        <th>#</th>

                        <th>Student</th>

                        <th>Class</th>

                        <th>Subject</th>

                        <th>Academic Year</th>

                        <th>Term</th>

                        <th>Exam</th>

                        <th>Marks</th>

                        <th>Grade</th>

                        <th width="180">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($marks as $mark)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $mark->student->first_name }}

                                {{ $mark->student->last_name }}

                            </td>

                            <td>

                                {{ $mark->student->classroom->name ?? '-' }}

                            </td>

                            <td>

                                {{ $mark->subject->name }}

                            </td>

                            <td>

                                {{ $mark->exam->academicYear->name ?? '-' }}

                            </td>

                            <td>

                                {{ $mark->exam->term }}

                            </td>

                            <td>

                                {{ $mark->exam->name }}

                            </td>

                            <td>

                                {{ $mark->marks }}

                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $mark->grade }}

                                </span>

                            </td>

                            <td>

                                <a href="{{ route('marks.show',$mark) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="fa fa-eye"></i>

                                </a>

                                <a href="{{ route('marks.edit',$mark) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="fa fa-edit"></i>

                                </a>

                                <form action="{{ route('marks.destroy',$mark) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Delete this mark?')"
                                        class="btn btn-danger btn-sm">

                                        <i class="fa fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10" class="text-center">

                                No marks recorded.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">

        {{ $marks->links() }}

    </div>

</div>

@endsection