<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberProfile;
use App\Models\News;
use App\Models\Merchandise;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = MemberProfile::where('status', 'approved')->count();
        $pendingApplications = MemberProfile::where('status', 'pending')->count();

        $publishedNews = News::published()->count();
        $totalMerchandise = Merchandise::count();

        return view('admin.dashboard', [
            'totalMembers' => $totalMembers,
            'pendingApplications' => $pendingApplications,
            'publishedNews' => $publishedNews,
            'totalMerchandise' => $totalMerchandise,
        ]);
    }
}
