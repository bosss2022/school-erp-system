@extends('layouts.app')

@section('title', 'Exams')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                <i class="fa-solid fa-file-lines me-2"></i>
                Exams
            </h4>

            <a href="{{ route('exams.create') }}" class="btn btn-light">
                <i class="fa-solid fa-plus"></i>
                Add Exam
            </a>

        </div>

        <div class="card-body">

            <form action="{{ route('exams.index') }}" method="GET">

                <div class="row mb-4">

                    <div class="col-md-5">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search by exam, term or academic year">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-success w-100">

                            <i class="fa fa-search"></i>

                            Search

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a href="{{ route('exams.index') }}"
                           class="btn btn-secondary w-100">

                            <i class="fa fa-refresh"></i>

                            Reset

                        </a>

                    </div>

                </div>

            </form>

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-success">

                        <tr>

                            <th width="5%">#</th>

                            <th>Academic Year</th>

                            <th>Exam Name</th>

                            <th>Term</th>

                            <th>Exam Date</th>

                            <th width="22%">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($exams as $exam)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                <span class="badge bg-success">

                                    {{ $exam->academicYear->name ?? 'N/A' }}

                                </span>

                            </td>

                            <td>

                                {{ $exam->name }}

                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $exam->term }}

                                </span>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($exam->exam_date)->format('d M Y') }}

                            </td>

                            <td>

                                <a href="{{ route('exams.show',$exam) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="fa fa-eye"></i>

                                </a>

                                <a href="{{ route('exams.edit',$exam) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="fa fa-edit"></i>

                                </a>

                                <form action="{{ route('exams.destroy',$exam) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Delete this exam?')"
                                        class="btn btn-danger btn-sm">

                                        <i class="fa fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                <div class="py-4">

                                    <i class="fa-solid fa-file-circle-xmark fa-3x text-muted mb-3"></i>

                                    <h5>No Exams Found</h5>

                                    <p class="text-muted">

                                        Click <strong>Add Exam</strong> to create one.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $exams->links() }}

            </div>

        </div>

    </div>

</div>

@endsection