@extends('layouts.guest')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 via-white to-green-50 px-6 py-12">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

        <!-- Header -->
        <div class="bg-green-700 py-8 px-6 text-center">

            <img src="{{ asset('storage/images/logo.png') }}"
                 alt="School Logo"
                 class="h-20 w-20 mx-auto bg-white rounded-full p-2 shadow-lg">

            <h2 class="text-3xl font-bold text-white mt-4">
                Leaders' Portal
            </h2>

            <p class="text-green-100 mt-2">
                Sign in to continue
            </p>

        </div>

        <!-- Form -->
        <div class="p-8">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->

                <div class="mb-5">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Email Address

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600 @error('email') border-red-500 @enderror">

                    @error('email')

                        <p class="text-red-500 text-sm mt-1">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                <!-- Password -->

                <div class="mb-5">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600 @error('password') border-red-500 @enderror">

                    @error('password')

                        <p class="text-red-500 text-sm mt-1">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                <!-- Remember -->

                <div class="flex items-center justify-between mb-6">

                    <label class="flex items-center">

                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-green-600 focus:ring-green-500">

                        <span class="ml-2 text-sm text-gray-600">

                            Remember Me

                        </span>

                    </label>

                   <div class="text-center mt-5">

    <p class="text-sm text-gray-600">

        Forgot your password?

    </p>

    <p class="text-sm text-green-700 font-semibold mt-1">

     Visit the School Admin.

    </p>

</div>

                 

                </div>

                <!-- Button -->

                <button
                    type="submit"
                    class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-3 rounded-lg shadow-lg transition duration-300">

                    Login

                </button>

            </form>

        </div>

        <!-- Footer -->

        <div class="bg-gray-50 py-4 text-center border-t">

            <p class="text-sm text-gray-500">

                © {{ date('Y') }} BossoftTechSolutions

            </p>

        </div>

    </div>

</div>

@endsection