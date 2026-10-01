@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">

                <i class="fa-solid fa-calendar-plus me-2"></i>

                Schedule Guardian Meeting

            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('meetings.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Meeting Title

                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               required>

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Date

                        </label>

                        <input type="date"
                               name="meeting_date"
                               class="form-control"
                               required>

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Time

                        </label>

                        <input type="time"
                               name="meeting_time"
                               class="form-control"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Venue

                        </label>

                        <input type="text"
                               name="venue"
                               class="form-control"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Target Meeting Type

                        </label>

                        <select name="target_type"
                                id="targetType"
                                class="form-select">

                            <option value="all">

                                All Guardians

                            </option>

                            <option value="class">

                                Specific Class

                            </option>

                            <option value="individual">

                                Individual Guardian

                            </option>

                        </select>

                    </div>


                    <div class="col-md-6 mb-3"
                         id="classroomDiv"
                         style="display:none">

                        <label class="form-label">

                            Classroom

                        </label>

                        <select name="classroom_id"
                                class="form-select">

                            <option value="">
                                Select Class
                            </option>

                            @foreach($classrooms as $classroom)

                                <option value="{{ $classroom->id }}">

                                    {{ $classroom->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-12 mb-3"
                         id="guardianDiv"
                         style="display:none">

                        <label class="form-label">

                            Select Guardians

                        </label>

                        <select name="guardian_ids[]"
                                multiple
                                class="form-select">

                            @foreach($guardians as $guardian)

                                <option value="{{ $guardian->id }}">

                                    {{ $guardian->first_name }}
                                    {{ $guardian->last_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Meeting Agenda

                        </label>

                        <textarea name="agenda"
                                  rows="5"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <button class="btn btn-success">

                    <i class="fa-solid fa-save me-2"></i>

                    Schedule Meeting

                </button>

            </form>

        </div>

    </div>

</div>

<script>

document.getElementById('targetType')
.addEventListener('change', function() {

    document.getElementById('classroomDiv').style.display = 'none';

    document.getElementById('guardianDiv').style.display = 'none';

    if(this.value === 'class') {

        document.getElementById('classroomDiv').style.display = 'block';
    }

    if(this.value === 'individual') {

        document.getElementById('guardianDiv').style.display = 'block';
    }

});

</script>

@endsection