@extends('layouts.admin')

@section('title', 'Detail Member')

@section('content')
    <div class="p-6 space-y-6">

        <div>
            <h1 class="text-xl font-semibold text-gray-800">Detail Profil Member</h1>
        </div>

        <div>
            <a href="{{ route('admin.members.index') }}"
               class="text-sm text-gray-600 hover:underline">
                ← Kembali ke Daftar Member
            </a>
        </div>

        <div class="bg-white shadow rounded-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Foto Profil</p>
                    @if ($member->photo_url)
                        <img src="{{ $member->photo_url }}"
                             class="w-32 h-32 object-cover rounded border" />
                    @else
                        <p class="text-sm text-gray-400">
                            Tidak ada foto profil
                        </p>
                    @endif
                </div>


                <div>
                    <p class="text-sm text-gray-500 mb-1">QR Code</p>

                    @if ($member->qr_code_url)
                        <div class="space-y-2">
                            <img src="{{ $member->qr_code_url }}"
                                 class="w-32 h-32 border rounded">

                            @if ($member->qr_verification_url)
                                <a href="{{ $member->qr_verification_url }}"
                                   target="_blank"
                                   class="block text-xs text-blue-600 hover:underline">
                                    Lihat Profile
                                </a>
                            @endif
                        </div>
                    @else
                        <span class="text-sm text-gray-400">-</span>
                    @endif
                </div>
            </div>

            <div class="md:col-span-2">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">

                    <div>
                        <dt class="text-gray-500">Nama Lengkap</dt>
                        <dd class="font-medium text-gray-800">{{ $member->full_name }}</dd>
                    </div>

                    <div>
                        <dt class="text-gray-500">Email</dt>
                        <dd class="font-medium text-gray-800">{{ $member->email }}</dd>
                    </div>

                    <div>
                        <dt class="text-gray-500">Nomor HP</dt>
                        <dd class="font-medium text-gray-800">{{ $member->phone }}</dd>
                    </div>

                    <div>
                        <dt class="text-gray-500">Kota</dt>
                        <dd class="font-medium text-gray-800">{{ $member->city ?? '-' }}</dd>
                    </div>

                    <div>
                        <dt class="text-gray-500">Alamat</dt>
                        <dd class="font-medium text-gray-800">{{ $member->address ?? '-' }}</dd>
                    </div>

                    <div>
                        <dt class="text-gray-500">Tanggal Lahir</dt>
                        <dd class="font-medium text-gray-800">
                            {{ $member->birth_date?->translatedFormat('d M Y') ?? '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-gray-500">ID Member</dt>
                        <dd class="font-mono text-xs text-gray-800">
                            {{ $member->membership_id ?? '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-gray-500">Status</dt>
                        <dd>
                            @if ($member->isApproved())
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                Approved
                            </span>
                            @elseif ($member->isPending())
                                <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                Rejected
                            </span>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-gray-500">Join Date</dt>
                        <dd class="font-medium text-gray-800">
                            {{ $member->approved_at?->translatedFormat('d M Y H:i') ?? '-' }}
                        </dd>
                    </div>

                </dl>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Bukti Pembayaran
            </h2>

            @if ($member->payment_proof_url)
                <a href="{{ $member->payment_proof_url }}"
                   target="_blank"
                   class="text-blue-600 hover:underline text-sm">
                    Lihat Bukti Pembayaran
                </a>
            @else
                <p class="text-sm text-gray-500">Tidak tersedia</p>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Membership History
            </h2>

            @if ($member->histories->isEmpty())
                <p class="text-sm text-gray-500">
                    Belum ada riwayat keanggotaan.
                </p>
            @else
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Tipe</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Deskripsi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y">
                    @foreach ($member->histories as $history)
                        <tr>
                            <td class="px-4 py-2">
                                {{ $history?->created_at?->translatedFormat('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ ucfirst($history->type) }}
                            </td>
                            <td class="px-4 py-2">
                                {{ ucfirst($history->status) }}
                            </td>
                            <td class="px-4 py-2 text-gray-600">
                                {{ $history->description ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
