@extends('layouts.admin')

@section('title', 'Pendaftaran Member')

@section('content')
    <div class="container mx-auto px-4">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Member Management
            </h1>
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

        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">No. HP</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($applications as $application)
                    <tr class="border-b">
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $application->full_name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $application->email }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $application->phone }}
                        </td>

                        <td class="px-4 py-3">
                            @if ($application->status === 'pending')
                                <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            @elseif ($application->status === 'approved')
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                    Approved
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                    Rejected
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.applications.show', $application->id) }}"
                               class="text-blue-600 hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Tidak ada pendaftaran pending.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $applications->links() }}
        </div>

    </div>
@endsection
