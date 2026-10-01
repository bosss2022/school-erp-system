@extends('layouts.app')

@section('title', 'Edit Communication')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">

            <h4 class="mb-0">

                <i class="fa-solid fa-pen-to-square me-2"></i>

                Edit Guardian Communication

            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('guardian-communications.update',$guardianCommunication) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Title --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Title</label>

                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="{{ old('title',$guardianCommunication->title) }}"
                            required>

                    </div>

                    {{-- Subject --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Subject</label>

                        <input
                            type="text"
                            name="subject"
                            class="form-control"
                            value="{{ old('subject',$guardianCommunication->subject) }}"
                            required>

                    </div>

                    {{-- Type --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Communication Type

                        </label>

                        <select
                            name="type"
                            class="form-select"
                            required>

                            <option value="announcement"
                                {{ $guardianCommunication->type=='announcement' ? 'selected' : '' }}>
                                Announcement
                            </option>

                            <option value="memo"
                                {{ $guardianCommunication->type=='memo' ? 'selected' : '' }}>
                                Memo
                            </option>

                            <option value="newsletter"
                                {{ $guardianCommunication->type=='newsletter' ? 'selected' : '' }}>
                                Newsletter
                            </option>

                            <option value="alert"
                                {{ $guardianCommunication->type=='alert' ? 'selected' : '' }}>
                                Emergency Alert
                            </option>

                            <option value="individual"
                                {{ $guardianCommunication->type=='individual' ? 'selected' : '' }}>
                                Individual Message
                            </option>

                        </select>

                    </div>

                    {{-- Recipient Type --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Recipient Type

                        </label>

                        <select
                            name="recipient_type"
                            id="recipient_type"
                            class="form-select"
                            required>

                            <option value="all"
                                {{ $guardianCommunication->recipient_type=='all' ? 'selected' : '' }}>
                                All Guardians
                            </option>

                            <option value="class"
                                {{ $guardianCommunication->recipient_type=='class' ? 'selected' : '' }}>
                                Specific Class
                            </option>

                            <option value="individual"
                                {{ $guardianCommunication->recipient_type=='individual' ? 'selected' : '' }}>
                                Individual Guardian
                            </option>

                        </select>

                    </div>

                    {{-- Classroom --}}
                    <div class="col-md-6 mb-3
                        {{ $guardianCommunication->recipient_type=='class' ? '' : 'd-none' }}"
                        id="classroom_div">

                        <label class="form-label">

                            Classroom

                        </label>

                        <select
                            name="classroom_id"
                            class="form-select">

                            <option value="">Select Classroom</option>

                            @foreach($classrooms as $classroom)

                                <option
                                    value="{{ $classroom->id }}"
                                    {{ $guardianCommunication->classroom_id==$classroom->id ? 'selected' : '' }}>

                                    {{ $classroom->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Guardian --}}
                    <div class="col-md-6 mb-3
                        {{ $guardianCommunication->recipient_type=='individual' ? '' : 'd-none' }}"
                        id="guardian_div">

                        <label class="form-label">

                            Guardian

                        </label>

                        <select
                            name="guardian_id"
                            class="form-select">

                            <option value="">Select Guardian</option>

                            @foreach($guardians as $guardian)

                                <option
                                    value="{{ $guardian->id }}">

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
                            required>{{ old('message',$guardianCommunication->message) }}</textarea>

                    </div>

                </div>

                <div class="text-end">

                    <a href="{{ route('guardian-communications.index') }}"
                       class="btn btn-secondary">

                        Cancel

                    </a>

                    <button
                        class="btn btn-warning">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Update Communication

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function(){

    const recipient = document.getElementById('recipient_type');

    const classroom = document.getElementById('classroom_div');

    const guardian = document.getElementById('guardian_div');

    function toggleFields(){

        classroom.classList.add('d-none');

        guardian.classList.add('d-none');

        if(recipient.value==='class'){

            classroom.classList.remove('d-none');

        }

        if(recipient.value==='individual'){

            guardian.classList.remove('d-none');

        }

    }

    recipient.addEventListener('change',toggleFields);

    toggleFields();

});

</script>

@endpush