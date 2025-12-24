@extends('layouts.app')

@section('title', 'Set Password')

@section('content')
    <div class="max-w-md mx-auto mt-12 p-6 bg-white rounded-lg shadow">

        <h1 class="text-xl font-semibold text-gray-800 mb-2">
            Set Password Akun Member
        </h1>

        <p class="text-sm text-gray-600 mb-6">
            Silakan buat password untuk akun member Anda agar dapat login ke sistem.
        </p>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-3 text-sm text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('member.password.store', $token) }}"
        >
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    type="email"
                    value="{{ $email }}"
                    readonly
                    class="mt-1 w-full rounded border-gray-300 bg-gray-100 text-gray-600 shadow-sm"
                >
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password Baru
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    minlength="8"
                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                <p class="mt-1 text-xs text-gray-500">
                    Minimal 8 karakter.
                </p>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Konfirmasi Password
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    minlength="8"
                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-700 transition"
            >
                Simpan Password & Login
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                Link ini hanya bisa digunakan satu kali.
            </p>
        </div>

    </div>
@endsection
