
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4 bg-light min-vh-100">

    <div class="container">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

            <div>

                <h1 class="display-5 fw-bold text-dark">
                    Activity Logs
                </h1>

                <p class="text-muted mt-2">
                    Monitor all user activities, logins, updates and actions
                </p>

            </div>

            <div class="mt-3 mt-md-0">

                <div class="bg-dark text-white px-4 py-3 rounded shadow">

                    Total Logs:
                    <span class="fw-bold">
                        {{ $logs->total() }}
                    </span>

                </div>

            </div>

        </div>


        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="alert alert-success shadow-sm">

                {{ session('success') }}

            </div>

        @endif


        {{-- TABLE CARD --}}
        <div class="card border-0 shadow-lg">

            {{-- TOP BAR --}}
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">

                <div>

                    <h2 class="h4 fw-bold mb-1">
                        System Activity Timeline
                    </h2>

                    <p class="small text-light mb-0">
                        Real-time monitoring of ERP activities
                    </p>

                </div>

                <div class="fs-2 opacity-50">
                    📋
                </div>

            </div>


            {{-- TABLE --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="text-uppercase small fw-bold">
                                User
                            </th>

                            <th class="text-uppercase small fw-bold">
                                Action
                            </th>

                            <th class="text-uppercase small fw-bold">
                                Description
                            </th>

                            <th class="text-uppercase small fw-bold">
                                IP Address
                            </th>

                            <th class="text-uppercase small fw-bold">
                                Browser / Device
                            </th>

                            <th class="text-uppercase small fw-bold">
                                Date
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($logs as $log)

                            <tr>

                                {{-- USER --}}
                                <td>

                                    <div class="d-flex align-items-center">

                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold me-3"
                                             style="width: 45px; height: 45px;">

                                            {{ strtoupper(substr($log->user->name ?? 'U', 0, 1)) }}

                                        </div>

                                        <div>

                                            <div class="fw-semibold text-dark">

                                                {{ $log->user->name ?? 'Unknown User' }}

                                            </div>

                                            <small class="text-muted">

                                                ID:
                                                {{ $log->user_id ?? 'N/A' }}

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- ACTION --}}
                                <td>

                                    @php

                                        $badge = 'secondary';

                                        if(str_contains(strtolower($log->action), 'login')) {
                                            $badge = 'success';
                                        }

                                        elseif(str_contains(strtolower($log->action), 'delete')) {
                                            $badge = 'danger';
                                        }

                                        elseif(str_contains(strtolower($log->action), 'update')) {
                                            $badge = 'warning';
                                        }

                                        elseif(str_contains(strtolower($log->action), 'create')) {
                                            $badge = 'primary';
                                        }

                                    @endphp

                                    <span class="badge bg-{{ $badge }} px-3 py-2">

                                        {{ $log->action }}

                                    </span>

                                </td>


                                {{-- DESCRIPTION --}}
                                <td class="text-muted">

                                    {{ $log->description ?? 'No description available' }}

                                </td>


                                {{-- IP --}}
                                <td>

                                    <span class="badge bg-light text-dark border">

                                        {{ $log->ip_address }}

                                    </span>

                                </td>


                                {{-- DEVICE --}}
                                <td class="text-muted small">

                                    {{ $log->user_agent }}

                                </td>


                                {{-- DATE --}}
                                <td>

                                    <div class="fw-semibold text-dark">

                                        {{ $log->created_at->format('d M Y') }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $log->created_at->format('h:i A') }}

                                    </small>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-5">

                                    <div class="d-flex flex-column align-items-center">

                                        <div class="display-1 opacity-50 mb-3">
                                            📭
                                        </div>

                                        <h2 class="h4 fw-bold text-secondary">
                                            No Activity Logs Found
                                        </h2>

                                        <p class="text-muted mt-2">
                                            System activities will appear here.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION --}}
        <div class="mt-4">

            {{ $logs->links() }}

        </div>

    </div>

</div>

@endsection

