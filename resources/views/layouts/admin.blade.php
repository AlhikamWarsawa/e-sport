<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100 text-gray-900">

@php
    $admin = Auth::guard('admin')->user();
@endphp

<header class="bg-gray-800 text-white shadow" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-8 md:px-6 lg:px-4 py-4 flex justify-between items-center border-b md:border-none">

        <div class="flex items-center gap-4">
            <a href="#" class="text-lg font-semibold">Admin Panel</a>

            @if($admin)
                <span class="text-sm text-gray-300">
                        {{ $admin->name }}
                    </span>
            @endif
        </div>

        <!-- Desktop Nav -->
        @if($admin)
            <nav class="space-x-6 hidden md:flex items-center">
                <x-nav-link href="{{ route('admin.dashboard') }}"
                            :active="request()->routeIs('admin.dashboard')"
                            admin>
                    Dashboard
                </x-nav-link>

                <x-nav-link href="{{ route('admin.activity_logs.index') }}"
                            :active="request()->routeIs('admin.activity_logs.*')"
                            admin>
                    Logs
                </x-nav-link>

                <x-nav-link href="{{ route('admin.members.index') }}"
                            :active="request()->routeIs('admin.members.*')"
                            admin>
                    Members
                </x-nav-link>

                <x-nav-link href="{{ route('admin.news.index') }}"
                            :active="request()->routeIs('admin.news.*')"
                            admin>
                    News
                </x-nav-link>

                <x-nav-link href="{{ route('admin.applications.index') }}"
                            :active="request()->routeIs('admin.applications.*')"
                            admin>
                    Applications
                </x-nav-link>

                <x-nav-link href="{{ route('admin.merchandise.index') }}"
                            :active="request()->routeIs('admin.merchandise.*')"
                            admin>
                    Merchandise
                </x-nav-link>

                <x-nav-link href="{{ route('admin.settings.index') }}"
                            :active="request()->routeIs('admin.settings.*')"
                            admin>
                    Setting
                </x-nav-link>

                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="hover:text-red-400 text-sm">
                        Logout
                    </button>
                </form>
            </nav>
        @endif

        {{-- Mobile Toggle --}}
        <button
            @click="open = !open"
            class="md:hidden text-2xl"
        >
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>

            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile Nav -->
    @if($admin)
        <nav
            class="md:hidden pt-0.5 pb-3.5"
            x-show="open"
            x-transition
        >
            <x-nav-link href="{{ route('admin.dashboard') }}"
                        :active="request()->routeIs('admin.dashboard')"
                        admin>
                Dashboard
            </x-nav-link>

            <x-nav-link href="{{ route('admin.activity_logs.index') }}"
                        :active="request()->routeIs('admin.activity_logs.*')"
                        admin>
                Logs
            </x-nav-link>

            <x-nav-link href="{{ route('admin.members.index') }}"
                        :active="request()->routeIs('admin.members.*')"
                        admin>
                Members
            </x-nav-link>

            <x-nav-link href="{{ route('admin.news.index') }}"
                        :active="request()->routeIs('admin.news.*')"
                        admin>
                News
            </x-nav-link>

            <x-nav-link href="{{ route('admin.applications.index') }}"
                        :active="request()->routeIs('admin.applications.*')"
                        admin>
                Applications
            </x-nav-link>

            <x-nav-link href="{{ route('admin.merchandise.index') }}"
                        :active="request()->routeIs('admin.merchandise.*')"
                        admin>
                Merchandise
            </x-nav-link>

            <x-nav-link href="{{ route('admin.settings.index') }}"
                        :active="request()->routeIs('admin.settings.*')"
                        admin>
                Setting
            </x-nav-link>

            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                @csrf
                <button class="hover:text-red-400 text-sm">
                    Logout
                </button>
            </form>
        </nav>
    @endif
</header>

<main class="max-w-7xl mx-auto px-4 py-6">
    @yield('content')
</main>

</body>
</html>
