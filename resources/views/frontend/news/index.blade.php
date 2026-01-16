@extends('layouts.app')

@section('title', 'News')

@section('content')

    <div class="w-full mx-auto">
        <div class="bg-gray-50 border border-gray-200 rounded px-6 py-8 text-center">

            <p class="text-xs lg:text-sm font-semibold tracking-widest text-gray-500 uppercase">
                Welcome to Esport News
            </p>

            <p class="text-base sm:text-lg lg:text-xl xl:text-2xl text-gray-800 mt-2 font-medium w-full sm:w-2/3 lg:w-1/2 mx-auto">
                Berita Esport Fans Club, 
                <span class="text-blue-500">Main</span> Bareng, </br>
                <span class="text-blue-500">Menang</span> Bareng, 
                <span class="text-blue-500">Gila</span> Bareng!
            </p>
        </div>
    </div>

    <h1 class="text-3xl font-semibold text-gray-800 py-8 mt-2">Latest Fansclub News</h1>

    @if ($news->count())
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($news as $item)
                <x-layouts.components.card
                    :title="$item->title"
                    :image="$item->thumbnail_url"
                    :link="route('news.show', $item->slug)"
                >
                    <div class="space-y-4">
                        <p class="text-gray-700 leading-relaxed">{{ $item->summary }}</p>
                        <p class="text-sm text-gray-400 border-t border-gray-400 pt-2">{{ $item->published_at ?? '-' }}</p>
                    </div>
                </x-layouts.components.card>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $news->links('pagination::tailwind') }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-600">No news articles have been published yet. Please check back soon.</p>
        </div>
    @endif
@endsection
