<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::current();

        if (!$settings) {
            abort(500, 'Settings fansclub belum disiapkan.');
        }

        return view('frontend.home', compact('settings'));
    }
}
