@extends('layouts.app')

@section('title', 'Communication Details')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">

                <i class="fa-solid fa-envelope-open-text text-success me-2"></i>

                Communication Details

            </h3>

            <p class="text-muted mb-0">

                View communication information and delivery status.

            </p>

        </div>

        <a href="{{ route('guardian-communications.index') }}"
           class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left me-2"></i>

            Back

        </a>

    </div>

    {{-- Communication Information --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">

                Communication Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>Title</strong>

                    <p>{{ $guardianCommunication->title }}</p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Subject</strong>

                    <p>{{ $guardianCommunication->subject }}</p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Type</strong>

                    <p>

                        <span class="badge bg-primary">

                            {{ ucfirst($guardianCommunication->type) }}

                        </span>

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Recipient</strong>

                    <p>

                        {{ ucfirst($guardianCommunication->recipient_type) }}

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Created By</strong>

                    <p>

                        {{ $guardianCommunication->creator->name ?? '-' }}

                    </p>

                </div>

                @if($guardianCommunication->classroom)

                <div class="col-md-6 mb-3">

                    <strong>Classroom</strong>

                    <p>

                        {{ $guardianCommunication->classroom->name }}

                    </p>

                </div>

                @endif

                <div class="col-md-6 mb-3">

                    <strong>Sent On</strong>

                    <p>

                        {{ optional($guardianCommunication->sent_at)->format('d M Y h:i A') }}

                    </p>

                </div>

                <div class="col-md-12">

                    <strong>Message</strong>

                    <div class="border rounded p-3 bg-light">

                        {!! nl2br(e($guardianCommunication->message)) !!}

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Recipients --}}
    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <div class="d-flex justify-content-between">

                <h5 class="mb-0">

                    Delivery Report

                </h5>

                <span class="badge bg-light text-dark">

                    {{ $guardianCommunication->recipients->count() }} Recipient(s)

                </span>

            </div>

        </div>

        <div class="card-body">

            @if($guardianCommunication->recipients->count())

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Guardian</th>

                            <th>Email</th>

                            <th>Status</th>

                            <th>Sent At</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($guardianCommunication->recipients as $recipient)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>

                               {{ $recipient->guardian ? $recipient->guardian->first_name . ' ' . $recipient->guardian->last_name : '-' }}

                            </td>

                            <td>

                                {{ $recipient->email }}

                            </td>

                            <td>

                                @if($recipient->status == 'Sent')

                                    <span class="badge bg-success">

                                        Sent

                                    </span>

                                @elseif($recipient->status == 'Pending')

                                    <span class="badge bg-warning">

                                        Pending

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Failed

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ optional($recipient->sent_at)->format('d M Y h:i A') }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @else

                <div class="alert alert-info">

                    No recipients found for this communication.

                </div>

            @endif

        </div>

    </div>

</div>

@endsection