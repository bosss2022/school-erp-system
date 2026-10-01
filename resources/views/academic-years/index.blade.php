@extends('layouts.app')

@section('title', 'Academic Years')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                <i class="fa-solid fa-calendar-days me-2"></i>
                Academic Years
            </h4>

            <a href="{{ route('academic-years.create') }}" class="btn btn-light">
                <i class="fa-solid fa-plus"></i>
                New Academic Year
            </a>

        </div>

        <div class="card-body">

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

                            <th>Start Date</th>

                            <th>End Date</th>

                            <th width="15%">Status</th>

                            <th width="20%">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($years as $year)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>

                                <strong>{{ $year->name }}</strong>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($year->start_date)->format('d M Y') }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($year->end_date)->format('d M Y') }}

                            </td>

                            <td>

                                @if($year->is_current)

                                    <span class="badge bg-success">

                                        Current

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        Closed

                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('academic-years.show',$year) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="fa-solid fa-eye"></i>

                                </a>

                                <a href="{{ route('academic-years.edit',$year) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="fa-solid fa-pen"></i>

                                </a>

                                <form action="{{ route('academic-years.destroy',$year) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Delete this Academic Year?')"
                                        class="btn btn-danger btn-sm">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                <div class="py-4">

                                    <i class="fa-solid fa-calendar-xmark fa-3x text-muted mb-3"></i>

                                    <h5>No Academic Years Found</h5>

                                    <p class="text-muted">

                                        Click <strong>New Academic Year</strong> to create one.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $years->links() }}

            </div>

        </div>

    </div>

</div>

@endsection