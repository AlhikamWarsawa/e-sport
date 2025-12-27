@extends('layouts.app')

@section('title', 'Verifikasi Member')

@section('content')
    <div class="max-w-md mx-auto py-16 px-4">

        <div class="bg-white shadow rounded-lg p-6 text-center space-y-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">
                    Member Terverifikasi
                </h1>
            </div>

            <div class="border rounded-lg divide-y text-sm">

                <div class="flex justify-between px-4 py-3">
                    <span class="text-gray-500">Nama</span>
                    <span class="font-medium text-gray-800">
                    {{ $member->full_name }}
                </span>
                </div>

                <div class="flex justify-between px-4 py-3">
                    <span class="text-gray-500">ID Member</span>
                    <span class="font-mono text-xs text-gray-800">
                    {{ $member->membership_id }}
                </span>
                </div>

                <div class="flex justify-between px-4 py-3">
                    <span class="text-gray-500">Status</span>
                    <span class="px-2 py-0.5 text-xs rounded bg-green-100 text-green-700">
                    Active
                </span>
                </div>

                <div class="flex justify-between px-4 py-3">
                    <span class="text-gray-500">Bergabung</span>
                    <span class="text-gray-800">
                    {{ $member->approved_at?->translatedFormat('d M Y') }}
                </span>
                </div>

            </div>
        </div>

    </div>
@endsection
