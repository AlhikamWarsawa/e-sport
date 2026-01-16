@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <article class="max-w-4xl mx-auto p-6 bg-white">

        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 mb-6 transition">
        ← Back to all news
        </a>

        <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
            {{ $news->title }}
        </h1>

        <p class="text-sm text-gray-500 mt-2">
            Published on
            {{ optional($news->published_at)->format('F d, Y') ?? '-' }}
        </p>

        @if($news->thumbnail_url)
            <div class="mt-6">
                <img src="{{ $news->thumbnail_url }}"
                     alt="{{ $news->title }}"
                     loading="lazy"
                     class="w-full h-80 object-cover rounded-xl shadow-md">
            </div>
        @endif

        <div class="mt-8 prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! $news->content !!}
        </div>

        <section class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                Share this article
            </h2>

            @php
                $shareUrl = urlencode(request()->fullUrl());
                $shareTitle = urlencode($news->title);
            @endphp

            <div class="flex items-center gap-4">
                <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Share on X"
                   class="group">
                    <img src="/images/share/logo1.jpg"
                         alt="Share on X"
                         class="w-7 h-7 rounded-full border border-gray-300 group-hover:opacity-80 transition">
                </a>

                <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Share on WhatsApp"
                   class="group">
                    <img src="/images/share/logo2.png"
                         alt="Share on WhatsApp"
                         class="w-7 h-7 rounded-full border border-gray-300 group-hover:opacity-80 transition">
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Share on Facebook"
                   class="group">
                    <img src="/images/share/logo3.jpg"
                         alt="Share on Facebook"
                         class="w-7 h-7 rounded-full border border-gray-300 group-hover:opacity-80 transition">
                </a>
            </div>
        </section>

    </article>
@endsection
