@extends('layouts.app')

@section('title', 'Guardian Communications')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold">
                <i class="fa-solid fa-envelope-open-text text-success me-2"></i>
                Guardian Communications
            </h3>
            <p class="text-muted mb-0">
                Send announcements, memos, newsletters and alerts to guardians.
            </p>
        </div>

        <a href="{{ route('guardian-communications.create') }}"
           class="btn btn-success">

            <i class="fa-solid fa-plus me-2"></i>

            New Communication

        </a>

    </div>

    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

    {{-- Card --}}
    <div class="card shadow border-0">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">

                Communication History

            </h5>

        </div>

        <div class="card-body">

            @if($communications->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Title</th>

                            <th>Subject</th>

                            <th>Type</th>

                            <th>Recipients</th>

                            <th>Created By</th>

                            <th>Sent</th>

                            <th width="220">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($communications as $communication)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>

                                <strong>

                                    {{ $communication->title }}

                                </strong>

                            </td>

                            <td>

                                {{ $communication->subject }}

                            </td>

                            <td>

                                @php

                                    $badge = match($communication->type){

                                        'announcement' => 'primary',

                                        'memo' => 'warning',

                                        'newsletter' => 'info',

                                        'alert' => 'danger',

                                        default => 'secondary'

                                    };

                                @endphp

                                <span class="badge bg-{{ $badge }}">

                                    {{ ucfirst($communication->type) }}

                                </span>

                            </td>

                            <td>

                                {{ ucfirst($communication->recipient_type) }}

                            </td>

                            <td>

                                {{ $communication->creator->name ?? '-' }}

                            </td>

                            <td>

                                {{ optional($communication->sent_at)->format('d M Y H:i') }}

                            </td>

                            <td>

                                <a href="{{ route('guardian-communications.show',$communication) }}"
                                   class="btn btn-sm btn-info">

                                    <i class="fa-solid fa-eye"></i>

                                </a>

                                <a href="{{ route('guardian-communications.edit',$communication) }}"
                                   class="btn btn-sm btn-warning">

                                    <i class="fa-solid fa-pen"></i>

                                </a>

                                <form action="{{ route('guardian-communications.destroy',$communication) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this communication?')">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $communications->links() }}

            </div>

            @else

                <div class="text-center py-5">

                    <i class="fa-solid fa-envelope-open fa-5x text-success mb-3"></i>

                    <h4>No Communications Found</h4>

                    <p class="text-muted">

                        Click the button above to send your first communication.

                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection