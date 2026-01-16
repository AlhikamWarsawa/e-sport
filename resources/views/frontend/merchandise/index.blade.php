@extends('layouts.app')

@section('title', 'Merchandise')

@section('content')
    <div class="w-full mx-auto">
        <div class="bg-gray-50 border border-gray-200 rounded px-6 py-8 text-center">

            <p class="text-xs lg:text-sm font-semibold tracking-widest text-gray-500 uppercase">
                Welcome to Esport Store
            </p>

            <p class="text-base sm:text-lg lg:text-xl xl:text-2xl text-gray-800 mt-2 font-medium w-full sm:w-2/3 lg:w-1/2 mx-auto">
                Merch Official Esport Fans Club, 
                <span class="text-blue-500">Main</span> Bareng, </br>
                <span class="text-blue-500">Menang</span> Bareng, 
                <span class="text-blue-500">Gila</span> Bareng!
            </p>
        </div>
    </div>

    <h1 class="text-lg lg:text-2xl xl:text-3xl font-semibold text-gray-800 py-8 mt-2">Fansclub Exclusive Merchandise</h1>

    @if ($merchandise->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">   
            @foreach ($merchandise as $item)
                <div class="bg-white rounded shadow-sm border border-gray-100 overflow-hidden flex flex-col group">
                    <div class="relative overflow-hidden">
                        <img
                            src="{{ $item->image_url }}"
                            alt="{{ $item->name }}"
                            class="h-80 w-full object-cover transition-transform duration-300 group-hover:scale-105 rounded-lg"
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

        <div class="mt-10">
            {{ $merchandise->links('pagination::tailwind') }}
        </div>

    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-600">Belum ada merchandise tersedia. Silakan cek kembali nanti.</p>
        </div>
    @endif
@endsection
