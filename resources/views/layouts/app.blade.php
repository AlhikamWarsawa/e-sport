<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', $settings->fansclub_name ?? 'Fansclub')
    </title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-800">

<header class="bg-white shadow" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-8 md:px-6 lg:px-4 py-4 flex justify-between items-center border-b md:border-none">

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            @if(!empty($settings?->logo_url))
                <img src="{{ $settings->logo_url }}"
                     alt="{{ $settings->fansclub_name }} Logo"
                     class="w-9 h-9 rounded-full object-cover">
            @endif

            <span class="text-xl font-bold">
                {{ $settings->fansclub_name ?? 'Fansclub' }}
            </span>
        </a>

        {{-- Desktop Nav --}}
        <nav class="space-x-6 hidden md:flex items-center">

            @auth('admin')
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">
                    Admin
                </a>
            @endauth

            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                Home
            </x-nav-link>

            <x-nav-link href="{{ route('news.index') }}" :active="request()->routeIs('news.*')">
                News
            </x-nav-link>

            <x-nav-link href="{{ route('merchandise.index') }}" :active="request()->routeIs('merchandise.*')">
                Merchandise
            </x-nav-link>

            @auth('member')
                <x-nav-link href="{{ route('member.profile') }}" :active="request()->routeIs('member.profile')">
                    Profile
                </x-nav-link>
            @else
                <x-nav-link href="{{ route('member.register') }}" :active="request()->routeIs('member.register')">
                    Membership
                </x-nav-link>
            @endauth

            @auth('member')
                <form action="{{ route('member.logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="hover:text-red-500">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('member.login') }}" class="hover:text-blue-600">
                    Login
                </a>
            @endauth
        </nav>

        {{-- Mobile Toggle --}}
        <button @click="open = !open" class="md:hidden text-2xl">
            <span x-show="!open">
                ☰
            </span>
            <span x-show="open">
                ✕
            </span>
        </button>
    </div>

    {{-- Mobile Nav --}}
    <nav x-show="open" x-transition class="md:hidden pb-3">
        @auth('admin')
            <a href="{{ route('admin.dashboard') }}" class="block px-8 py-2 hover:text-blue-600">
                Admin
            </a>
        @endauth

        <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" mobile>
            Home
        </x-nav-link>

        <x-nav-link href="{{ route('news.index') }}" :active="request()->routeIs('news.*')" mobile>
            News
        </x-nav-link>

        <x-nav-link href="{{ route('merchandise.index') }}" :active="request()->routeIs('merchandise.*')" mobile>
            Merchandise
        </x-nav-link>

        @auth('member')
            <x-nav-link href="{{ route('member.profile') }}" :active="request()->routeIs('member.profile')" mobile>
                Profile
            </x-nav-link>
        @else
            <x-nav-link href="{{ route('member.register') }}" :active="request()->routeIs('member.register')" mobile>
                Membership
            </x-nav-link>
        @endauth

        @auth('member')
            <form action="{{ route('member.logout') }}" method="POST" class="px-8 py-2">
                @csrf
                <button class="hover:text-red-500">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('member.login') }}" class="block px-8 py-2 hover:text-blue-600">
                Login
            </a>
        @endauth
    </nav>
</header>

<main class="max-w-7xl mx-auto px-4 py-4">
    @yield('content')
</main>

<footer class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-sm text-gray-600">
        © {{ date('Y') }} {{ $settings->fansclub_name ?? 'Fansclub' }}. All rights reserved.
    </div>
</footer>

</body>
</html>
