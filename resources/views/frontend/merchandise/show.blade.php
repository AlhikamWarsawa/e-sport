@extends('layouts.app')

@section('title', $item->name)

@section('content')
    <div class="max-w-5xl mx-auto py-10">

        <a href="{{ route('merchandise.index') }}"
           class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 mb-6">
            ← Back to all merchandise
        </a>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 md:p-8">
            <div class="flex flex-col md:flex-row gap-8 items-start">

                <div class="w-full md:w-64 lg:w-72 shrink-0">
                    <img
                        src="{{ $item->image_url }}"
                        alt="{{ $item->name }}"
                        class="w-full aspect-[4/5] object-cover rounded-xl border border-gray-200"
                    >
                </div>

                <div class="flex-1 space-y-5">

                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">
                            {{ $item->name }}
                        </h1>

                        @if ($item->price)
                            <p class="mt-1 text-lg font-medium text-emerald-700">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        @else
                            <p class="mt-1 text-sm text-gray-500">Harga belum tersedia</p>
                        @endif
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 md:p-5">
                        <h2 class="sr-only">Deskripsi merchandise</h2>
                        <div class="text-sm md:text-base text-gray-700 leading-relaxed">
                            {!! nl2br(e($item->description)) !!}
                        </div>
                    </div>

                    @if ($item->links->count())
                        <div class="pt-1">
                            <p class="text-sm font-medium text-gray-700 mb-2">
                                Barang Tersedia:
                            </p>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($item->links as $link)
                                    <a
                                        href="{{ $link->url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="px-4 py-2 text-sm font-medium border border-gray-400 rounded-full
                                               text-gray-800 hover:bg-gray-100 transition"
                                    >
                                        {{ $link->shop_name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="pt-1">
                            <p class="text-sm font-medium text-red-500 mb-2">
                                Barang Tidak Tersedia
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
