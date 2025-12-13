@extends('layouts.admin')

@section('title', 'Admin Login')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-lg shadow p-6">

            <h1 class="text-2xl font-semibold text-center mb-6">
                Login Admin
            </h1>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                    >
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-black text-white py-2 rounded hover:bg-gray-800 transition"
                >
                    Login
                </button>
            </form>

        </div>
    </div>
@endsection
