@extends('layouts.admin')

@section('title', 'Admin Activity Logs')

@section('content')
    <div class="max-w-7xl mx-auto py-6">

        <div class="mb-6">
            <h1 class="text-xl font-semibold text-gray-800">
                Admin Activity Logs
            </h1>
        </div>

        <form method="GET" class="mb-4 flex items-center gap-3">
            <select name="action"
                    class="border rounded px-3 py-2 text-sm">
                <option value="">Semua Aksi</option>
                @php
                    $actions = [
                        'approve_member',
                        'reject_member',
                        'create_news',
                        'update_news',
                        'delete_news',
                        'toggle_news_status',
                        'create_merchandise',
                        'update_merchandise',
                        'delete_merchandise',
                        'update_settings',
                    ];
                @endphp

                @foreach ($actions as $action)
                    <option value="{{ $action }}"
                        {{ request('action') === $action ? 'selected' : '' }}>
                        {{ $action }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="px-4 py-2 bg-gray-800 text-white text-sm rounded">
                Filter
            </button>

            @if(request()->has('action'))
                <a href="{{ route('admin.activity_logs.index') }}"
                   class="text-sm text-gray-600 underline">
                    Reset
                </a>
            @endif
        </form>

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100 text-left text-sm text-gray-600">
                <tr>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Admin</th>
                    <th class="px-4 py-3">Aksi</th>
                    <th class="px-4 py-3">Data</th>
                </tr>
                </thead>

                <tbody class="text-sm text-gray-700">
                @forelse ($logs as $log)
                    <tr class="border-t">
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $log->admin->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-2 py-1 bg-gray-200 rounded text-xs">
                                {{ $log->action }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            @if (!empty($log->data))
                                <pre class="text-xs bg-gray-50 p-2 rounded overflow-x-auto">
{{ json_encode($log->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
                                </pre>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="px-4 py-6 text-center text-gray-500">
                            Tidak ada activity log.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </div>
@endsection
