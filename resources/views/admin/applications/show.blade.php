@extends('layouts.admin')

@section('title', 'Detail Pendaftaran Member')

@section('content')
    <div class="container mx-auto px-4 max-w-4xl">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Detail Pendaftaran Member
            </h1>
            <p class="text-sm text-gray-500">
                ID Pendaftaran: {{ $application->membership_id }}
            </p>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 border border-green-200 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded bg-red-100 border border-red-200 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6 space-y-6">

            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">
                    Data Member
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Nama Lengkap</span>
                        <p class="font-medium text-gray-800">{{ $application->full_name }}</p>
                    </div>

                    <div>
                        <span class="text-gray-500">Email</span>
                        <p class="font-medium text-gray-800">{{ $application->email }}</p>
                    </div>

                    <div>
                        <span class="text-gray-500">Nomor HP</span>
                        <p class="font-medium text-gray-800">{{ $application->phone }}</p>
                    </div>

                    <div>
                        <span class="text-gray-500">Kota</span>
                        <p class="font-medium text-gray-800">{{ $application->city ?? '-' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <span class="text-gray-500">Alamat</span>
                        <p class="font-medium text-gray-800">{{ $application->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">
                    Status Pendaftaran
                </h2>

                @if ($application->status === 'pending')
                    <span class="inline-block px-3 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                    Pending
                </span>
                @elseif ($application->status === 'approved')
                    <span class="inline-block px-3 py-1 text-xs rounded bg-green-100 text-green-700">
                    Approved
                </span>
                @else
                    <span class="inline-block px-3 py-1 text-xs rounded bg-red-100 text-red-700">
                    Rejected
                </span>
                @endif
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">
                    Bukti Pembayaran
                </h2>

                @if ($application->payment_proof_url)
                    <a href="{{ $application->payment_proof_url }}"
                       target="_blank"
                       class="text-blue-600 hover:underline">
                        Lihat Bukti Pembayaran
                    </a>
                @else
                    <p class="text-sm text-gray-500">
                        Bukti pembayaran tidak tersedia.
                    </p>
                @endif
            </div>

            @if ($application->status === 'pending')
                <div class="border-t pt-6 flex flex-col md:flex-row gap-4">

                    <form method="POST"
                          action="{{ route('admin.applications.approve', $application->id) }}">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Approve
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('admin.applications.reject', $application->id) }}"
                          class="flex gap-2">
                        @csrf
                        <input type="text"
                               name="rejected_reason"
                               placeholder="Alasan penolakan"
                               class="border rounded px-3 py-2 text-sm w-64">
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Reject
                        </button>
                    </form>

                </div>
            @endif

        </div>

        <div class="mt-6">
            <a href="{{ route('admin.applications.index') }}"
               class="text-sm text-gray-600 hover:underline">
                ← Kembali ke daftar pendaftaran
            </a>
        </div>

    </div>
@endsection
