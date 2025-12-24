@extends('layouts.app')

@section('title', 'Profil Member')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Profil Member
            </h1>
            <p class="text-sm text-gray-500">
                Informasi keanggotaan
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid md:grid-cols-3 gap-6">

                <div class="text-center">

                    <img
                        src="{{ $profile->photo_url ?? asset('images/default-avatar.png') }}"
                        alt="Foto Profil"
                        class="w-32 h-32 mx-auto rounded-full border object-cover"
                    >

                    @if ($profile->isApproved() && $profile->qr_code_url)
                        <img
                            src="{{ $profile->qr_code_url }}"
                            alt="QR Code Member"
                            class="w-40 h-40 mx-auto mt-4 border rounded"
                        >
                        <p class="text-xs text-gray-500 mt-2">
                            QR Code Member
                        </p>
                    @endif
                </div>

                <div class="md:col-span-2">
                    <table class="w-full text-sm">

                        <tr>
                            <td class="py-2 text-gray-600 w-40">Nama</td>
                            <td class="font-medium text-gray-800">
                                {{ $profile->full_name }}
                            </td>
                        </tr>

                        <tr>
                            <td class="py-2 text-gray-600">Email</td>
                            <td>{{ $profile->email }}</td>
                        </tr>

                        <tr>
                            <td class="py-2 text-gray-600">ID Member</td>
                            <td class="font-mono text-gray-800">
                                {{ $profile->membership_id ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="py-2 text-gray-600">Status</td>
                            <td>
                            <span class="px-2 py-1 text-xs rounded
                                {{ $profile->isApproved()
                                    ? 'bg-green-100 text-green-700'
                                    : ($profile->isPending()
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($profile->status) }}
                            </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="py-2 text-gray-600">Join Date</td>
                            <td>
                                {{ $profile->approved_at
                                    ? $profile->approved_at->format('d M Y')
                                    : '-' }}
                            </td>
                        </tr>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
