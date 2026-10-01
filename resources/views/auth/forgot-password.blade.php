@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-sky-100 to-white px-6 py-12">
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8 border-t-8 border-sky-700">

        <!-- Header -->
        <div class="text-center mb-6">
            <img src="storage/images/logo.png" alt="School Logo" class="h-16 mx-auto mb-3">
            <h2 class="text-2xl font-bold text-sky-800 mb-1">Forgot Your Password?</h2>
            <p class="text-gray-500 text-sm">We’ll send a reset link to your email address.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200">
                {{ session('status') }}
            </div>
        @endif

        <!-- Reset Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-sky-700 hover:underline">Back to login</a>
                <button type="submit"
                    class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white rounded-lg font-semibold shadow-md transition">
                    Send Reset Link
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="mt-6 border-t border-gray-200 pt-4 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} BossoftTechSolutions. All rights reserved.</p>
        </div>
    </div>
</div>
@endsection
