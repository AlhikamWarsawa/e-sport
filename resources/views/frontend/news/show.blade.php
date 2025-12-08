@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <article class="max-w-4xl mx-auto">
        <a href="{{ route('news.index') }}"
           class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 mb-6">
            ← Back to all news
        </a>

        <h1 class="text-4xl font-bold text-gray-900 leading-tight">{{ $news->title }}</h1>
        <p class="text-gray-500 mt-2">Published on {{ $news->published_at ?? '-' }}</p>

        <div class="mt-6">
            <img src="{{ $news->thumbnail_url }}"
                 alt="{{ $news->title }}"
                 class="w-full h-80 object-cover rounded-xl shadow">
        </div>

        <div class="mt-6 text-lg text-gray-700 leading-relaxed prose">
            {!! $news->content !!}
        </div>

        <h2 class="text-2xl font-bold text-gray-900 leading-tight mt-10 mb-3">Share It</h2>

        @php
            $shareUrl = urlencode(request()->fullUrl());
            $shareTitle = urlencode($news->title);
        @endphp

        <div class="flex items-center gap-4">
            <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}"
               target="_blank">
                <img src="/images/share/logo1.jpg"
                     alt="Share to WhatsApp"
                     class="w-10 h-10 hover:opacity-80 transition border-2 border-gray-300 rounded-full">
            </a>

            <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}"
               target="_blank">
                <img src="/images/share/logo2.png"
                     alt="Share to X"
                     class="w-10 h-10 hover:opacity-80 transition border-2 border-gray-300 rounded-full">
            </a>

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
               target="_blank">
                <img src="/images/share/logo3.jpg"
                     alt="Share to Facebook"
                     class="w-10 h-10 hover:opacity-80 transition border-2 border-gray-300 rounded-full">
            </a>
        </div>

    </article>
@endsection
