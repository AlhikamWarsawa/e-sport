<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberProfile;
use Illuminate\Http\Request;

class MemberAdminController extends Controller
{
    public function index()
    {
        $members = MemberProfile::query()
            ->with('user')
            ->orderByRaw("
                CASE status
                    WHEN 'approved' THEN 1
                    WHEN 'pending' THEN 2
                    WHEN 'rejected' THEN 3
                END
            ")
            ->orderByDesc('approved_at')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.members.index', compact('members'));
    }

    public function show(string $membershipId)
    {
        $member = MemberProfile::with([
            'user',
            'histories' => function ($q) {
                $q->orderByDesc('created_at');
            },
        ])
            ->where('membership_id', $membershipId)
            ->firstOrFail();

        return view('admin.members.show', compact('member'));
    }
}
