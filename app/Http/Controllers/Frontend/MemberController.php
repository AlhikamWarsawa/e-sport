<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberProfile;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberPendingMail;

class MemberController extends Controller
{
    public function create()
    {
        return view('frontend.member.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string|max:150',
            'email'         => 'required|email|max:150|unique:member_profiles,email',
            'phone'         => 'required|string|max:20',
            'birth_date'    => 'nullable|date',
            'address'       => 'nullable|string',
            'city'          => 'nullable|string|max:20',
            'username'      => 'required|string|max:50|unique:member_profiles,membership_id',
            'payment_proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $directory = storage_path('app/public/proof');
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $proofPath = $request->file('payment_proof')->store('proof', 'public');

        $membershipId = $request->username;

        $member = MemberProfile::create([
            'full_name'      => $request->full_name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'birth_date'     => $request->birth_date,
            'address'        => $request->address,
            'city'           => $request->city,
            'photo'          => null,
            'membership_id'  => $membershipId,
            'payment_proof'  => $proofPath,
            'status'         => 'pending',
            'approved_at'    => null,
            'rejected_reason'=> null,
        ]);

        Mail::to($member->email)->send(new MemberPendingMail($member));

        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim. Menunggu verifikasi admin. Cek email secara berkala');
    }
}
