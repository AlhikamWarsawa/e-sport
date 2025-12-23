@extends('layouts.app')

@section('title', 'Profil Member')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Profil Member
            </h1>
            <p class="text-sm text-gray-500">
                Informasi keanggotaan fansclub
            </p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">

            @if($profile->status === 'pending')
                <div class="mb-4 p-3 rounded bg-yellow-50 text-yellow-700 text-sm">
                    Pendaftaran kamu masih dalam proses peninjauan admin.
                </div>
            @elseif($profile->status === 'rejected')
                <div class="mb-4 p-3 rounded bg-red-50 text-red-700 text-sm">
                    Pendaftaran kamu belum disetujui. Silakan hubungi admin jika membutuhkan informasi lebih lanjut.
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-6">

                <div class="md:w-1/3 text-center">
                    <div class="mb-4">
                        <img
                            src="{{ $profile->photo ? asset($profile->photo) : asset('images/default-avatar.png') }}"
                            alt="Foto Member"
                            class="w-32 h-32 mx-auto rounded-full object-cover border"
                        >
                    </div>

                    @if($profile->status === 'approved' && $profile->qr_code_path)
                        <div class="mt-4">
                            <img
                                src="{{ asset($profile->qr_code_path) }}"
                                alt="QR Code Member"
                                class="w-40 h-40 mx-auto border rounded"
                            >
                            <p class="text-xs text-gray-500 mt-2">
                                QR Code Member
                            </p>
                        </div>
                    @endif
                </div>

                <div class="md:w-2/3">
                    <table class="w-full text-sm">
                        <tbody class="divide-y">

                        <tr>
                            <td class="py-2 font-medium text-gray-600 w-40">Nama</td>
                            <td class="py-2 text-gray-800">{{ $profile->full_name }}</td>
                        </tr>

                        <tr>
                            <td class="py-2 font-medium text-gray-600">Email</td>
                            <td class="py-2 text-gray-800">{{ $profile->email }}</td>
                        </tr>

                        <tr>
                            <td class="py-2 font-medium text-gray-600">Nomor HP</td>
                            <td class="py-2 text-gray-800">{{ $profile->phone ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="py-2 font-medium text-gray-600">Alamat</td>
                            <td class="py-2 text-gray-800">
                                {{ $profile->address ?? '-' }}
                                @if($profile->city)
                                    , {{ $profile->city }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td class="py-2 font-medium text-gray-600">ID Member</td>
                            <td class="py-2 text-gray-800 font-mono">
                                {{ $profile->membership_id ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="py-2 font-medium text-gray-600">Status</td>
                            <td class="py-2">
                                @if($profile->status === 'approved')
                                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                        Approved
                                    </span>
                                @elseif($profile->status === 'pending')
                                    <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                        </tr>

                        @if($profile->approved_at)
                            <tr>
                                <td class="py-2 font-medium text-gray-600">Disetujui pada</td>
                                <td class="py-2 text-gray-800">
                                    {{ $profile->approved_at->format('d M Y, H:i') }}
                                </td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
