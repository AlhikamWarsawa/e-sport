<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('frontend.news.index', [
            'news' => $news,
        ]);
    }

    public function show(string $slug)
    {
        $news = News::where('slug', $slug)->first();

        abort_if(is_null($news), 404);

        return view('frontend.news.show', [
            'news' => $news,
        ]);
    }
}
