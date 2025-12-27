<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberProfile;
use Illuminate\Http\Request;

class MemberVerificationController extends Controller
{
    public function show(string $token)
    {
        $member = MemberProfile::where('qr_token', $token)->first();

        if (!$member) {
            abort(404, 'QR Code tidak valid.');
        }

        if (
            $member->qr_token_expires_at &&
            now()->greaterThan($member->qr_token_expires_at)
        ) {
            abort(410, 'QR Code sudah kedaluwarsa.');
        }

        if (!$member->isApproved()) {
            abort(403, 'Keanggotaan belum aktif.');
        }

        return view('frontend.member.verify', [
            'member' => $member,
        ]);
    }
}
