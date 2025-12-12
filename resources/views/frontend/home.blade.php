@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="w-full bg-white text-gray-800 py-20 rounded-2xl shadow-md">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <div class="space-y-8">

                    <div class="flex items-center gap-5">
                        <img src="/images/logo.png"
                             alt="Esport Logo"
                             class="w-20 h-20 rounded-full bg-gray-100 p-2 shadow-lg ring-1 ring-gray-200">

                        <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight leading-none">
                            Esport
                        </h1>
                    </div>

                    <p class="text-gray-600 text-lg leading-relaxed max-w-lg">
                        Esport Fans Club, Main Bareng, Menang Bareng, Gila Bareng!
                    </p>

                    <a href="/member/register"
                       class="inline-block px-10 py-3.5 rounded-full bg-blue-600 text-white font-semibold shadow-lg
                          hover:bg-blue-700 hover:shadow-blue-300/40 transition-all duration-300">
                        Daftar Member
                    </a>
                </div>

                <div class="relative">
                    <div class="absolute inset-0 bg-blue-300/20 rounded-3xl blur-2xl"></div>

                    <img src="/images/banner.png"
                         alt="Esport Banner"
                         class="relative w-full h-[330px] md:h-[460px] object-cover rounded-3xl shadow-2xl border border-gray-200">
                </div>


            </div>
        </div>
    </section>
@endsection
