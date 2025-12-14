@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-2xl font-semibold mb-6">
            Dashboard
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white rounded-lg shadow p-5">
                <div class="text-sm text-gray-500 mb-1">
                    Total Members
                </div>
                <div class="text-3xl font-bold text-gray-900">
                    {{ $totalMembers }}
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5">
                <div class="text-sm text-gray-500 mb-1">
                    Pending Applications
                </div>
                <div class="text-3xl font-bold text-yellow-600">
                    {{ $pendingApplications }}
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5">
                <div class="text-sm text-gray-500 mb-1">
                    Published News
                </div>
                <div class="text-3xl font-bold text-blue-600">
                    {{ $publishedNews }}
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5">
                <div class="text-sm text-gray-500 mb-1">
                    Total Merchandise
                </div>
                <div class="text-3xl font-bold text-green-600">
                    {{ $totalMerchandise }}
                </div>
            </div>

        </div>

    </div>
@endsection
