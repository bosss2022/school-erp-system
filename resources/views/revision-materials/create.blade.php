
@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h1 class="fw-bold text-dark">
                        Upload Revision Material
                    </h1>

                    <p class="text-muted mb-0">
                        Upload notes, assignments, past papers and more
                    </p>

                </div>

                <a href="{{ route('revision-materials.index') }}"
                   class="btn btn-dark px-4">

                    Back

                </a>

            </div>


            {{-- ERRORS --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORM CARD --}}
            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header bg-primary text-white py-3 rounded-top-4">

                    <h4 class="mb-0 fw-bold">
                        Revision Material Details
                    </h4>

                </div>


                <div class="card-body p-4">

                    <form action="{{ route('revision-materials.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf


                        {{-- TITLE --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Title

                            </label>

                            <input type="text"
                                   name="title"
                                   value="{{ old('title') }}"
                                   placeholder="Enter material title"
                                   class="form-control form-control-lg">

                        </div>


                        {{-- DESCRIPTION --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Description

                            </label>

                            <textarea name="description"
                                      rows="5"
                                      placeholder="Optional description..."
                                      class="form-control">{{ old('description') }}</textarea>

                        </div>


                        {{-- GRID --}}
                        <div class="row">

                            {{-- SUBJECT --}}
                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Subject

                                </label>

                                <select name="subject_id"
                                        class="form-select">

                                    <option value="">

                                        Select Subject

                                    </option>

                                    @foreach($subjects as $subject)

                                        <option value="{{ $subject->id }}">

                                            {{ $subject->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- CLASSROOM --}}
                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Classroom

                                </label>

                                <select name="classroom_id"
                                        class="form-select">

                                    <option value="">

                                        Select Classroom

                                    </option>

                                    @foreach($classrooms as $classroom)

                                        <option value="{{ $classroom->id }}">

                                            {{ $classroom->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- TYPE --}}
                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Material Type

                                </label>

                                <select name="type"
                                        class="form-select">

                                    <option value="">

                                        Select Type

                                    </option>

                                    <option value="notes">

                                        Notes

                                    </option>

                                    <option value="assignment">

                                        Assignment

                                    </option>

                                    <option value="pastpaper">

                                        Past Paper

                                    </option>

                                    <option value="marking_scheme">

                                        Marking Scheme

                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- FILE --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Upload File

                            </label>

                            <input type="file"
                                   name="file"
                                   class="form-control">

                            <small class="text-muted">

                                Allowed:
                                PDF, DOCX, PPTX, ZIP

                            </small>

                        </div>


                        {{-- BUTTON --}}
                        <div class="d-grid">

                            <button type="submit"
                                    class="btn btn-primary btn-lg fw-bold">

                                Upload Material

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
