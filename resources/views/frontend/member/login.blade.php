@extends('layouts.app')

@section('title', 'Login Member')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-lg shadow p-6">

            <h1 class="text-2xl font-semibold text-center mb-2">
                Login Member
            </h1>

            <p class="text-sm text-gray-500 text-center mb-6">
                Login untuk Mengakses Profil
            </p>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('member.login.submit') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
                        placeholder="email@example.com"
                    >
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
                        placeholder="Password"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700 transition"
                >
                    Login
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('member.register') }}" class="text-blue-600 hover:underline">
                    Daftar Member
                </a>
            </div>

        </div>
    </div>
@endsection
