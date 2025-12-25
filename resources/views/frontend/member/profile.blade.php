@extends('layouts.app')

@section('title', 'Profil Member')

@section('content')
    <div class="min-h-screen bg-gray-50 py-10 px-4">
        <div class="max-w-4xl mx-auto">

            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">
                    Profil Saya
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Informasi akun dan keanggotaan member
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="text-center">

                        <img
                            src="{{ $profile->photo_url ?? asset('images/default-avatar.png') }}"
                            alt="Foto Profil"
                            class="w-32 h-32 mx-auto rounded-full object-cover border"
                        >

                        <form action="{{ route('member.update.photo') }}" method="POST" enctype="multipart/form-data"
                              class="mt-4">

                            @csrf

                            <input
                                type="file"
                                name="photo"
                                accept="image/*"
                                class="block w-full text-sm text-gray-600
                                   file:mr-3 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-gray-100 file:text-gray-700
                                   hover:file:bg-gray-200"
                                required
                            >

                            <button
                                type="submit"
                                class="mt-3 w-full bg-blue-600 text-white py-2 rounded-lg
                                   text-sm font-semibold hover:bg-blue-700"
                            >
                                Update Foto Profil
                            </button>
                        </form>

                        <div class="mt-4">
                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                            {{ $profile->isApproved()
                                ? 'bg-green-100 text-green-700'
                                : ($profile->isPending()
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($profile->status) }}
                        </span>
                        </div>

                        @if ($profile->approved_at)
                            <div class="mt-2 text-xs text-gray-500">
                                Bergabung sejak {{ $profile->approved_at->format('d M Y') }}
                            </div>
                        @endif
                    </div>

                    <div class="md:col-span-2">
                        <table class="w-full text-sm text-gray-700">

                            <tr class="border-b">
                                <td class="py-3 w-40 text-gray-500">Nama Lengkap</td>
                                <td class="font-medium text-gray-900">
                                    {{ $profile->full_name }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3 text-gray-500">Email</td>
                                <td>{{ $profile->email }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3 text-gray-500">Nomor HP</td>
                                <td>{{ $profile->phone }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3 text-gray-500">Tanggal Lahir</td>
                                <td>{{ $profile->birth_date ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3 text-gray-500">ID Member</td>
                                <td class="font-mono text-gray-900">
                                    {{ $profile->membership_id ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3 text-gray-500">Alamat</td>
                                <td>{{ $profile->address ?? '-' }}</td>
                            </tr>

                            <tr>
                                <td class="py-3 text-gray-500">Kota</td>
                                <td>{{ $profile->city ?? '-' }}</td>
                            </tr>

                        </table>
                    </div>

                </div>
            </div>

            @if ($profile->isApproved() && $profile->qr_code_url)
                <div class="mt-8 bg-white border border-gray-200 rounded-xl p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        QR Code Member
                    </h2>

                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <img
                            src="{{ $profile->qr_code_url }}"
                            alt="QR Code Member"
                            class="w-36 h-36 border rounded"
                        >
                        <div class="text-sm text-gray-600">
                            <div>
                                <strong>ID Member:</strong>
                                <span class="font-mono">{{ $profile->membership_id }}</span>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                QR Code ini digunakan untuk verifikasi keanggotaan dan event resmi.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
