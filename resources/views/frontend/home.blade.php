@extends('layouts.app')

@section('title', $settings->fansclub_name)

@section('content')
    <section class="relative">
        <div class="relative w-full min-h-[520px] md:min-h-[620px]
                   bg-[url('/images/home/esport-stadium.jpg')] bg-center bg-cover
                   rounded-lg shadow-md overflow-hidden">

            <!-- overlays -->
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_transparent_40%,_rgba(0,0,0,0.75)_100%)]"></div>

            <div class="absolute top-5 left-1/2 -translate-x-1/2 text-center">
                <div class="flex items-center gap-2.5">
                    @if ($settings->logo_url)
                        <img
                            src="{{ $settings->logo_url }}"
                            alt="{{ $settings->fansclub_name }} Logo"
                            class="w-6 h-6 md:w-7 md:h-7 rounded-full bg-gray-100 shadow-lg">
                    @endif

                    <h1 class="text-sm md:text-lg font-medium text-gray-200 tracking-tight
                               [text-shadow:0_0_3px_rgba(255,255,255,0.6)]">
                        {{ $settings->fansclub_name }}
                    </h1>
                </div>
            </div>

            <div class="absolute top-16 md:top-20 inset-x-0 text-center px-4">
                <h1 class="uppercase font-extrabold text-white
                           [text-shadow:0_0_12px_rgba(255,255,255,0.5)]">
                    <span class="block text-3xl sm:text-4xl md:text-6xl lg:text-8xl">
                        Igniting the
                    </span>
                    <span class="block mt-2 text-xl sm:text-3xl md:text-4xl lg:text-6xl">
                        passion of esports
                    </span>
                </h1>
            </div>

            <div class="absolute bottom-8 md:bottom-16 inset-x-0 px-4 md:px-12 hidden lg:block">
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-20">

                    <div class="space-y-4 max-w-xl">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-4">
                                <img src="/images/home/kairi.jpg" class="w-10 h-10 md:w-12 md:h-12 rounded-full border-2 border-blue-400 object-cover">
                                <img src="/images/home/oner.jpeg" class="w-10 h-10 md:w-12 md:h-12 rounded-full border-2 border-blue-400 object-cover">
                                <img src="/images/home/karltzy.jpg" class="w-10 h-10 md:w-12 md:h-12 rounded-full border-2 border-blue-400 object-cover">
                                <img src="/images/home/yoshi-hide.jpg" class="w-10 h-10 md:w-12 md:h-12 rounded-full border-2 border-blue-400 object-cover">
                                <img src="/images/home/watches.jpg" class="w-10 h-10 md:w-12 md:h-12 rounded-full border-2 border-blue-400 object-cover">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-blue-500 flex items-center justify-center font-bold text-white">
                                    1K+
                                </div>
                            </div>

                            <span class="text-white text-sm xl:text-base font-semibold">
                                Player Profesional
                            </span>
                        </div>

                        <p class="text-gray-300 text-sm leading-relaxed w-full md:w-2/3">
                            Bertahun-tahun dominasi, momen-momen tak terlupakan, dan kepemimpinan
                            yang menginspirasi para penggemar di seluruh dunia.
                        </p>
                    </div>

                    <div class="max-w-md md:ml-40">
                        @if ($settings->banner_url)
                            <img
                                src="{{ $settings->banner_url }}"
                                alt="{{ $settings->fansclub_name }} Banner"
                                class="w-12 md:w-14 rounded-full mb-3">
                        @endif

                        <p class="text-gray-300 text-sm mb-5 leading-relaxed">
                            Setiap pertandingan menyalakan api yang hidup di hati para pemain
                            dan penggemar.
                        </p>

                        <a
                            href="{{ route('member.register') }}"
                            class="inline-block px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold
                                   hover:bg-blue-700 transition-all duration-300 shadow-lg">
                            Daftar Member
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <img
            src="/images/home/faker-pose.png"
            alt="faker"
            class="absolute top-40 left-1/2 -translate-x-1/2
                   w-[220px] md:w-[345px]
                   drop-shadow-[0_0_6px_rgba(255,255,255,0.35)]">
    </section>

    <section class="w-full text-gray-800 py-10 mt-10 rounded-2xl">
        <div class="max-w-7xl mx-auto px-6 md:px-10">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-10">
                <div class="leading-tight max-w-full sm:max-w-[70%]">
                    <h4 class="text-sm sm:text-lg text-blue-500 font-medium">
                        Recent News
                    </h4>
            
                    <h1 class="text-lg sm:text-2xl lg:text-3xl font-bold mt-1">
                        CERITA TERBESAR DI DUNIA ESPORTS SAAT INI
                    </h1>
                </div>
            
                <a
                    href="{{ route('news.index') }}"
                    class="self-start sm:self-auto text-xs sm:text-sm bg-blue-500 hover:bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg transition-all duration-200 whitespace-nowrap"
                >
                    See All
                </a>
            </div>
            

            @if ($news->count())
                <div class="grid gap-4 lg:grid-cols-1 xl:grid-cols-2">
                    @foreach ($news as $item)
                        <a href="{{ route('news.show', $item->slug) }}">
                            <div class="bg-white rounded shadow-md border border-gray-100 overflow-hidden flex items-stretch">

                                <img
                                    src="{{ $item->thumbnail_url }}"
                                    alt="{{ $item->slug }}"
                                    class="h-56 w-1/2 object-cover"
                                >

                                <div class="px-5 py-3 flex flex-col flex-1 justify-between">
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-900 mt-2">{{ $item->title }}</h2>
                                        <p class="text-gray-700 leading-relaxed mt-1">{{ $item->summary }}</p>
                                    </div>
                                
                                    <p class="text-sm text-gray-500 mt-auto pt-2 border-t border-gray-400">
                                        {{ $item->published_at ?? '-' }}
                                    </p>
                                </div>
                            
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <p class="text-gray-600">No news articles have been published yet. Please check back soon.</p>
                </div>
            @endif
        </div>
    </section>

    <section class="w-full text-gray-800 py-10 mt-10 rounded-2xl">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-12">
                <div class="leading-tight max-w-full sm:max-w-[70%]">
                    <h4 class="text-sm sm:text-lg text-blue-500 font-medium">
                        Official Merchandise
                    </h4>
            
                    <h1 class="text-lg sm:text-2xl lg:text-3xl font-bold mt-1">
                        MERCHANDISE EKSKLUSIF UNTUK PARA PENGGEMAR ESPORTS
                    </h1>
                </div>
            
                <a
                    href="{{ route('merchandise.index') }}"
                    class="self-start sm:self-auto text-xs sm:text-sm bg-blue-500 hover:bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg transition-all duration-200 whitespace-nowrap"
                >
                    See All
                </a>
            </div>
                

            @if ($merchandise->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                
                    @foreach ($merchandise as $item)
                        <div class="bg-white rounded shadow-sm border border-gray-100 overflow-hidden flex flex-col group">

                            <div class="relative overflow-hidden">
                                <img
                                    src="{{ $item->image_url }}"
                                    alt="{{ $item->name }}"
                                    class="h-96 w-full object-cover transition-transform duration-300 group-hover:scale-105 rounded-lg"
                                >
                            </div>
                        
                            <div class="flex flex-col flex-1 mt-1 p-4">
                            
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-semibold text-gray-900 leading-snug line-clamp-2">
                                        {{ $item->name }}
                                    </h2>
                                
                                    <p class="text-base font-semibold text-gray-600">
                                        {{ $item->price ? 'Rp ' . number_format($item->price, 0, ',', '.') : '—' }}
                                    </p>
                                </div>
                            
                                <div class="mt-auto pt-4">
                                    <a
                                        href="{{ route('merchandise.show', $item->slug) }}"
                                        class="inline-flex items-center justify-center w-full rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white border border-blue-500 hover:text-blue-500 hover:bg-white transition"
                                    >
                                        Lihat Detail
                                    </a>
                                </div>
                            
                            </div>
                        </div>

                    @endforeach
                    
                </div>
            
            @else
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <p class="text-gray-600">Belum ada merchandise tersedia. Silakan cek kembali nanti.</p>
                </div>
            @endif

        </div>
    </section>
@endsection
