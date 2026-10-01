@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-sky-100 to-white px-6 py-12">
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8 border-t-8 border-sky-700">

        <!-- Logo & Title -->
        <div class="text-center mb-6">
            <img src="storage/images/logo.png" alt="School Logo" class="h-16 mx-auto mb-3">
            <h2 class="text-3xl font-extrabold text-sky-800">Create an Account</h2>
            <p class="text-gray-500 text-sm">Register to access the school system</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Full Name -->
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-5">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Select Role</label>
                <select id="role" name="role" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-500 @error('role') border-red-500 @enderror">
                    <option value="">Choose role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        
                </select>
                @error('role')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-500 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-500">
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-sky-700 hover:underline">
                    Already registered?
                </a>
                <button type="submit"
                    class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white rounded-lg font-semibold shadow-md transition">
                    Register
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
