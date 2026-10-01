
@extends('layouts.app')

@section('content')

<div class="container-fluid py-5 bg-light min-vh-100">

    <div class="container">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

            <div>

                <h1 class="fw-bold text-dark display-5">
                    Revision Materials
                </h1>

                <p class="text-muted">
                    Notes, assignments, past papers and learning resources
                </p>

            </div>

            @if(auth()->user()->role != 'student')

                <a href="{{ route('revision-materials.create') }}"
                   class="btn btn-primary btn-lg mt-3 mt-md-0 shadow">

                    <i class="fa-solid fa-upload me-2"></i>
                    Upload Material

                </a>

            @endif

        </div>


        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="alert alert-success shadow-sm">

                {{ session('success') }}

            </div>

        @endif


        {{-- FILTERS --}}
        <div class="card border-0 shadow-sm mb-5">

            <div class="card-body">

                <form method="GET"
                      action="{{ route('revision-materials.index') }}">

                    <div class="row g-4">

                        {{-- SUBJECT --}}
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">

                                Subject

                            </label>

                            <select name="subject_id"
                                    class="form-select">

                                <option value="">

                                    All Subjects

                                </option>

                                @foreach($subjects as $subject)

                                    <option value="{{ $subject->id }}"
                                        {{ request('subject_id') == $subject->id ? 'selected' : '' }}>

                                        {{ $subject->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- TYPE --}}
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">

                                Material Type

                            </label>

                            <select name="type"
                                    class="form-select">

                                <option value="">

                                    All Types

                                </option>

                                <option value="notes"
                                    {{ request('type') == 'notes' ? 'selected' : '' }}>

                                    Notes

                                </option>

                                <option value="assignment"
                                    {{ request('type') == 'assignment' ? 'selected' : '' }}>

                                    Assignment

                                </option>

                                <option value="pastpaper"
                                    {{ request('type') == 'pastpaper' ? 'selected' : '' }}>

                                    Past Papers

                                </option>

                                <option value="marking_scheme"
                                    {{ request('type') == 'marking_scheme' ? 'selected' : '' }}>

                                    Marking Schemes

                                </option>

                            </select>

                        </div>


                        {{-- BUTTON --}}
                        <div class="col-md-4 d-flex align-items-end">

                            <button type="submit"
                                    class="btn btn-dark w-100">

                                <i class="fa-solid fa-filter me-2"></i>
                                Filter Materials

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- MATERIALS GRID --}}
        <div class="row g-4">

            @forelse($materials as $material)

                <div class="col-md-6 col-xl-4">

                    <div class="card border-0 shadow-sm h-100">

                        {{-- TOP --}}
                        <div class="card-header bg-primary text-white p-4 border-0">

                            <div class="d-flex justify-content-between align-items-center">

                                <span class="badge bg-light text-primary">

                                    {{ strtoupper(str_replace('_', ' ', $material->type)) }}

                                </span>

                                <small>

                                    {{ $material->created_at->diffForHumans() }}

                                </small>

                            </div>

                            <h4 class="fw-bold mt-4 mb-0">

                                {{ $material->title }}

                            </h4>

                        </div>


                        {{-- BODY --}}
                        <div class="card-body d-flex flex-column">

                            <div class="mb-3">

                                {{-- SUBJECT --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <span class="text-muted">
                                        Subject
                                    </span>

                                    <span class="badge bg-info text-dark">

                                        {{ $material->subject->name }}

                                    </span>

                                </div>


                                {{-- CLASSROOM --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <span class="text-muted">
                                        Classroom
                                    </span>

                                    <span class="badge bg-secondary">

                                        {{ $material->classroom->name }}

                                    </span>

                                </div>


                                {{-- TEACHER --}}
                                <div class="d-flex justify-content-between align-items-center">

                                    <span class="text-muted">
                                        Teacher
                                    </span>

                                    <span class="fw-semibold text-dark">

                                        {{ $material->teacher?->first_name ?? 'N/A' }}

                                    </span>

                                </div>

                            </div>


                            {{-- DESCRIPTION --}}
                            <div class="mb-4">

                                <p class="text-muted">

                                    {{ $material->description ?? 'No description available.' }}

                                </p>

                            </div>


                            {{-- ACTIONS --}}
                            <div class="mt-auto d-flex gap-2">

                                {{-- DOWNLOAD --}}
                                <a href="{{ route('revision-materials.show', $material->id) }}"
                                   class="btn btn-success flex-fill">

                                    <i class="fa-solid fa-download me-2"></i>
                                    Download

                                </a>


                                {{-- DELETE --}}
                                @if(auth()->user()->role != 'student')

                                    <form action="{{ route('revision-materials.destroy', $material->id) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('Delete this material?')"
                                                class="btn btn-danger">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="card border-0 shadow-sm">

                        <div class="card-body text-center py-5">

                            <h2 class="fw-bold text-dark mb-3">

                                No Materials Found

                            </h2>

                        
                        </div>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        <div class="mt-5">

            {{ $materials->links() }}

        </div>

    </div>

</div>

@endsection

