@extends('layouts.app')

@section('title', 'New Guardian Communication')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">
                <i class="fa-solid fa-envelope me-2"></i>
                New Guardian Communication
            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('guardian-communications.store') }}" method="POST">

                @csrf

                <div class="row">

                    {{-- Title --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Title</label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               required>

                    </div>

                    {{-- Subject --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Subject</label>

                        <input type="text"
                               name="subject"
                               class="form-control"
                               required>

                    </div>

                    {{-- Communication Type --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Communication Type</label>

                        <select name="type"
                                class="form-select"
                                required>

                            <option value="">Select Type</option>

                            <option value="announcement">Announcement</option>

                            <option value="memo">Memo</option>

                            <option value="newsletter">Newsletter</option>

                            <option value="alert">Emergency Alert</option>

                            <option value="individual">Individual Message</option>

                        </select>

                    </div>

                    {{-- Recipient --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Recipients</label>

                        <select name="recipient_type"
                                id="recipient_type"
                                class="form-select"
                                required>

                            <option value="">Select Recipient</option>

                            <option value="all">All Guardians</option>

                            <option value="class">Specific Class</option>

                            <option value="individual">Individual Guardian</option>

                        </select>

                    </div>

                    {{-- Classroom --}}

                    <div class="col-md-6 mb-3 d-none"
                         id="classroom_div">

                        <label class="form-label">

                            Classroom

                        </label>

                        <select name="classroom_id"
                                class="form-select">

                            <option value="">Select Classroom</option>

                            @foreach($classrooms as $classroom)

                                <option value="{{ $classroom->id }}">

                                    {{ $classroom->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Guardian --}}

                    <div class="col-md-6 mb-3 d-none"
                         id="guardian_div">

                        <label class="form-label">

                            Guardian

                        </label>

                        <select name="guardian_id"
                                class="form-select">

                            <option value="">Select Guardian</option>

                            @foreach($guardians as $guardian)

                                <option value="{{ $guardian->id }}">

                                  {{ $guardian->first_name }} {{ $guardian->last_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Message --}}

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Message

                        </label>

                        <textarea
                            name="message"
                            rows="8"
                            class="form-control"
                            required></textarea>

                    </div>

                </div>

                <div class="text-end">

                    <a href="{{ route('guardian-communications.index') }}"
                       class="btn btn-secondary">

                        Cancel

                    </a>

                    <button class="btn btn-success">

                        <i class="fa-solid fa-paper-plane me-2"></i>

                        Send Communication

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    let recipient = document.getElementById('recipient_type');

    let classroom = document.getElementById('classroom_div');

    let guardian = document.getElementById('guardian_div');

    recipient.addEventListener('change', function () {

        classroom.classList.add('d-none');

        guardian.classList.add('d-none');

        if(this.value === 'class')
        {
            classroom.classList.remove('d-none');
        }

        if(this.value === 'individual')
        {
            guardian.classList.remove('d-none');
        }

    });

});

</script>

@endpush