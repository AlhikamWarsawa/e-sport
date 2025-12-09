<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fansclub Esport')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="/" class="text-xl font-bold">Fansclub E-Sport</a>

        <nav class="space-x-6">
            <a href="/admin/dashboard" class="hover:text-blue-600">Dash Atmint</a>
            <a href="/" class="hover:text-blue-600">Home</a>
            <a href="/news" class="hover:text-blue-600">News</a>
            <a href="/merchandise" class="hover:text-blue-600">Merchandise</a>

            <form action="/admin/logout" method="POST" class="inline">
                @csrf
                <button class="hover:text-red-400">Logout</button>
            </form>
        </nav>
    </div>
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
