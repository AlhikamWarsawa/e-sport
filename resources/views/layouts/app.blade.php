<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fansclub Esport')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <header class="bg-white shadow" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-8 md:px-6 lg:px-4 py-4 flex justify-between items-center border-b md:border-none ">
            <a href="/" class="text-xl font-bold">Fansclub Esport</a>

            <!-- Desktop Nav -->
            <nav class="space-x-6 hidden md:flex items-center">
{{--                @if(Auth::guard('admin')->check())--}}
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">
                        Admin
                    </a>
{{--                @endif--}}
                <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                <x-nav-link href="/news" :active="request()->is('news')">News</x-nav-link>
                <x-nav-link href="/merchandise" :active="request()->is('merchandise')">Merchandise</x-nav-link>
                @auth('member')
                    <x-nav-link href="{{ route('member.profile') }}" :active="request()->is('member/profile')">
                        Profile
                    </x-nav-link>
                @else
                    <x-nav-link href="{{ route('member.register') }}" :active="request()->is('member/register')">
                        Membership
                    </x-nav-link>
                @endauth
                @auth('member')
                    <form action="{{ route('member.logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="hover:text-red-400">
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
            <button
                @click="open = !open"
                class=" md:hidden text-2xl"
            >
                <span x-show="!open">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </span>

                <span x-show="open">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </span>
            </button>
        </div>

        <!-- Mobile Nav -->
        <nav
            class="md:hidden pb-3.5"
            x-show="open"
            x-transition
        >
{{--            @if(Auth::guard('admin')->check())--}}
                <a href="{{ route('admin.dashboard') }}" class="block hover:text-blue-600 px-8 py-2">
                    Admin
                </a>
{{--            @endif--}}
            <x-nav-link href="/" :active="request()->is('/')" mobile>Home</x-nav-link>
            <x-nav-link href="/news" :active="request()->is('news')" mobile>News</x-nav-link>
            <x-nav-link href="/merchandise" :active="request()->is('merchandise')" mobile>Merchandise</x-nav-link>
            @auth('member')
                <x-nav-link href="{{ route('member.profile') }}" :active="request()->is('member/profile')">
                    Profile
                </x-nav-link>
            @else
                <x-nav-link href="{{ route('member.register') }}" :active="request()->is('member/register')">
                    Membership
                </x-nav-link>
            @endauth
            @auth('member')
                <form action="{{ route('member.logout') }}" method="POST" class="px-8 py-1.5">
                    @csrf
                    <button class="hover:text-red-400">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('member.login') }}"
                   class="block px-8 py-2 hover:text-blue-400">
                    Login
                </a>
            @endauth
        </nav>
    </header>


    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="bg-white shadow mt-10">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center text-sm text-gray-600">
            © {{ date('Y') }} Fansclub Esport. All rights reserved.
        </div>
    </footer>

</body>
</html>
