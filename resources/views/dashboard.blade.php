@extends('layouts.app')

@section('content')
    <div class="p-6 bg-white shadow rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Welcome, {{ auth()->user()->name }}</h2>

        @if(auth()->user()->role === 'admin')
            @include('dashboards.admin')
        @elseif(auth()->user()->role === 'student')
            @include('dashboards.student')
        @elseif(auth()->user()->role === 'teacher')
            @include('dashboards.teacher')
        @else
            <p class="text-gray-600">No dashboard assigned to your role.</p>
        @endif
    </div>
@endsection