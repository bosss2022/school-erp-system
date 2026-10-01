@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow border-0">

        <div class="card-header bg-warning">

            <h4 class="mb-0">

                <i class="fa-solid fa-pen me-2"></i>

                Edit Meeting

            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('meetings.update', $meeting->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Meeting Title
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ $meeting->title }}"
                               required>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Date
                        </label>

                        <input type="date"
                               name="meeting_date"
                               class="form-control"
                               value="{{ $meeting->meeting_date }}"
                               required>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Time
                        </label>

                        <input type="time"
                               name="meeting_time"
                               class="form-control"
                               value="{{ $meeting->meeting_time }}"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Venue
                        </label>

                        <input type="text"
                               name="venue"
                               class="form-control"
                               value="{{ $meeting->venue }}"
                               required>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Agenda
                        </label>

                        <textarea name="agenda"
                                  rows="5"
                                  class="form-control">{{ $meeting->agenda }}</textarea>

                    </div>

                </div>

                <button class="btn btn-success">

                    <i class="fa-solid fa-save me-2"></i>

                    Update Meeting

                </button>

                <a href="{{ route('meetings.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection