@extends('layouts.app')

@section('title', 'Edit Academic Year')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header bg-warning d-flex justify-content-between align-items-center">

                    <h4 class="mb-0 text-dark">
                        <i class="fa-solid fa-pen-to-square me-2"></i>
                        Edit Academic Year
                    </h4>

                    <a href="{{ route('academic-years.index') }}" class="btn btn-dark btn-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back
                    </a>

                </div>

                <div class="card-body">

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form action="{{ route('academic-years.update', $academicYear) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-3">

                            <label class="form-label">
                                Academic Year
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $academicYear->name) }}"
                                placeholder="Example: 2026/2027"
                                required>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Start Date
                                </label>

                                <input
                                    type="date"
                                    name="start_date"
                                    class="form-control"
                                    value="{{ old('start_date', $academicYear->start_date) }}"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    End Date
                                </label>

                                <input
                                    type="date"
                                    name="end_date"
                                    class="form-control"
                                    value="{{ old('end_date', $academicYear->end_date) }}"
                                    required>

                            </div>

                        </div>

                        <div class="form-check form-switch mb-4">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_current"
                                name="is_current"
                                value="1"
                                {{ old('is_current', $academicYear->is_current) ? 'checked' : '' }}>

                            <label class="form-check-label" for="is_current">

                                Set as Current Academic Year

                            </label>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">

                            <a href="{{ route('academic-years.index') }}"
                               class="btn btn-secondary me-2">

                                <i class="fa-solid fa-times"></i>

                                Cancel

                            </a>

                            <button type="submit" class="btn btn-warning">

                                <i class="fa-solid fa-floppy-disk"></i>

                                Update Academic Year

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection