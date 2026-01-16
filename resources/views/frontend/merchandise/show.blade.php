@extends('layouts.app')

@section('title', $item->name)

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-10">

        <a href="{{ route('merchandise.index') }}"
           class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 mb-6 transition">
            ← Back to all merchandise
        </a>

        <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2 py-14 pr-20">

                <div class="flex justify-center">
                    <img
                        src="{{ $item->image_url }}"
                        alt="{{ $item->name }}"
                        class="w-full max-w-sm aspect-[4/5] object-cover rounded border border-gray-200"
                    >
                </div>

                <div class="flex flex-col space-y-6">

                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">
                            {{ $item->name }}
                        </h1>

                        @if ($item->price)
                            <p class="mt-2 text-2xl font-semibold text-emerald-700">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        @else
                            <p class="mt-2 text-sm text-gray-500">
                                Harga belum tersedia
                            </p>
                        @endif
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-gray-900 mb-2">
                            Deskripsi Produk
                        </h2>

                        <div class="text-gray-700 leading-relaxed text-sm md:text-base bg-gray-50 border border-gray-200 rounded-xl p-4">
                            {!! nl2br(e($item->description)) !!}
                        </div>
                    </div>

                    <div class="pt-2">
                        @if ($item->links->count())
                            <p class="text-sm font-semibold text-gray-900 mb-3">
                                Tersedia di:
                            </p>

                            <div class="flex flex-wrap gap-3">
                                @foreach ($item->links as $link)
                                    <a
                                        href="{{ $link->url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium
                                               rounded-full border border-emerald-600 text-emerald-700
                                               hover:bg-emerald-600 hover:text-white transition"
                                    >
                                        {{ $link->shop_name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 px-4 py-2 rounded-lg">
                                Barang tidak tersedia
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
