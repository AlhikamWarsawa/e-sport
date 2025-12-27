@extends('layouts.admin')

@section('title', 'Daftar Member')

@section('content')
    <div class="p-6">

        <div class="mb-6">
            <h1 class="text-xl font-semibold text-gray-800">Daftar Member</h1>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">

            @if ($members->count() === 0)
                <div class="p-6 text-center text-gray-500">
                    Belum ada data member.
                </div>
            @else
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">ID Member</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Join Date</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y">
                    @foreach ($members as $member)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-mono text-xs">
                                {{ $member->membership_id ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $member->full_name }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $member->email }}
                            </td>

                            <td class="px-4 py-3">
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
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $member->approved_at
                                    ? $member->approved_at->format('d M Y')
                                    : '-' }}
                            </td>

                            <td class="px-4 py-3">
                                @if ($member->isApproved())
                                    <a href="{{ route('admin.members.show', $member->membership_id) }}"
                                       class="text-blue-600 hover:underline text-sm">
                                        Lihat Profil
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">
                                        -
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $members->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
