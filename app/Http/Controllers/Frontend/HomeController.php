<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use App\Models\News;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::current();
    
        if (!$settings) {
            abort(500, 'Settings fansclub belum disiapkan.');
        }
    
        $news = News::published()
            ->orderByDesc('published_at')
            ->take(4)
            ->get();
    
        $merchandise = Merchandise::with('links')
            ->latest()
            ->take(3)
            ->get();
    
        return view('frontend.home', compact('settings', 'news', 'merchandise'));
    }

}
