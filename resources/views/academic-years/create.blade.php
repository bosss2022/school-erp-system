@extends('layouts.app')

@section('title', 'Create Academic Year')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        <i class="fa-solid fa-calendar-plus me-2"></i>
                        Create Academic Year
                    </h4>

                    <a href="{{ route('academic-years.index') }}" class="btn btn-light btn-sm">
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

                    <form action="{{ route('academic-years.store') }}" method="POST">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">
                                Academic Year
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                placeholder="Example: 2026/2027"
                                required>

                            <small class="text-muted">
                                Example: 2026/2027
                            </small>

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
                                    value="{{ old('start_date') }}"
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
                                    value="{{ old('end_date') }}"
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
                                {{ old('is_current') ? 'checked' : '' }}>

                            <label class="form-check-label" for="is_current">

                                Set as Current Academic Year

                            </label>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">

                            <button type="reset" class="btn btn-secondary me-2">

                                <i class="fa-solid fa-rotate-left"></i>

                                Reset

                            </button>

                            <button type="submit" class="btn btn-success">

                                <i class="fa-solid fa-save"></i>

                                Save Academic Year

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
