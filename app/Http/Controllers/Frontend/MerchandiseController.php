<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;

class MerchandiseController extends Controller
{
    public function index()
    {
        $merchandise = Merchandise::with('links')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.merchandise.index', compact('merchandise'));
    }

    public function show($slug)
    {
        $item = Merchandise::with('links')
            ->where('slug', $slug)
            ->firstOrFail();

        $gallery = [$item->image_url];

        return view('frontend.merchandise.show', compact('item', 'gallery'));
    }

}
