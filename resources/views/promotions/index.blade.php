@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">

                <i class="fa-solid fa-arrow-up-right-dots me-2"></i>

                Student Promotion Module

            </h4>

        </div>


        <div class="card-body">

            <form method="GET"
                  action="{{ route('promotions.students', 0) }}"
                  id="promotionForm">

                <div class="row">

                    <div class="col-md-8">

                        <label class="form-label">

                            Select Current Class

                        </label>

                        <select name="classroom_id"
                                id="classroomSelect"
                                class="form-select"
                                required>

                            <option value="">

                                -- Select Class --

                            </option>

                            @foreach($classrooms as $classroom)

                                <option value="{{ $classroom->id }}">

                                    {{ $classroom->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-4 d-flex align-items-end">

                        <button class="btn btn-primary w-100">

                            <i class="fa-solid fa-users me-2"></i>

                            Load Students

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

document.getElementById('promotionForm')
.addEventListener('submit', function(e) {

    e.preventDefault();

    let classroomId = document
        .getElementById('classroomSelect')
        .value;

    window.location.href =
        "/promotions/students/" + classroomId;
});
</script>

@endsection