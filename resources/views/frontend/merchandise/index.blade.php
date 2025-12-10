@extends('layouts.app')

@section('title', 'Merchandise')

@section('content')
    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mt-1">Fansclub Exclusive Merchandise</h1>
            <p class="text-gray-600 mt-2">Merch Official Esport Fans Club. Main Bareng, Menang Bareng, Gila Bareng!</p>
        </div>
    </div>

    @if ($merchandise->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ($merchandise as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">

                    <img
                        src="{{ $item->image_url }}"
                        alt="{{ $item->name }}"
                        class="h-56 w-full object-cover"
                    >

                    <div class="p-5 space-y-3 flex flex-col flex-1">

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">{{ $item->name }}</h2>
                            <p class="text-sm text-gray-500">
                                {{ $item->price ? 'Rp ' . number_format($item->price, 0, ',', '.') : '—' }}
                            </p>
                        </div>

                        <div class="mt-auto">
                            <a
                                href="{{ route('merchandise.show', $item->slug) }}"
                                class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-emerald-600 text-white font-medium hover:bg-emerald-700 transition"
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
