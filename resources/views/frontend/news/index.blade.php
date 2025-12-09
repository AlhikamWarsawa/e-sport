@extends('layouts.app')

@section('title', 'News')

@section('content')
    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mt-1">Latest Fansclub News</h1>
            <p class="text-gray-600 mt-2">Berita Esport Fans Club, Main Bareng, Menang Bareng, Gila Bareng!</p>
        </div>
    </div>

    @if ($news->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($news as $item)
                <x-layouts.components.card
                    :title="$item->title"
                    :image="$item->thumbnail_url"
                    :link="route('news.show', $item->slug)"
                >
                    <p class="text-sm text-gray-500">{{ $item->published_at ?? '-' }}</p>
                    <p class="mt-3 text-gray-700 leading-relaxed">{{ $item->summary }}</p>
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
