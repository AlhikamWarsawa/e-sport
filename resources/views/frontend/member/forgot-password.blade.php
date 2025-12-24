@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-lg shadow p-6">

            <h1 class="text-2xl font-semibold text-center mb-1 text-gray-800">
                Lupa Password
            </h1>

            <p class="text-sm text-gray-500 text-center mb-6">
                Masukkan email yang terdaftar untuk menerima link reset password.
            </p>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('member.password.forgot.submit') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium mb-1 text-gray-700">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
                        placeholder="email@example.com"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700 transition"
                >
                    Kirim Link Reset Password
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-500">
                Kembali ke
                <a href="{{ route('member.login') }}" class="text-blue-600 hover:underline">
                    Login Member
                </a>
            </div>

        </div>
    </div>
@endsection
