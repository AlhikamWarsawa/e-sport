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

        $file = $request->file('payment_proof');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/proof'), $filename);

        $member = MemberProfile::create([
            'full_name'       => $request->full_name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'birth_date'      => $request->birth_date,
            'address'         => $request->address,
            'city'            => $request->city,
            'photo'           => null,
            'membership_id'   => $request->username,
            'payment_proof'   => $filename,
            'status'          => 'pending',
        ]);

        Mail::to($member->email)->send(new MemberPendingMail($member));

        return back()->with(
            'success',
            'Pendaftaran berhasil dikirim. Menunggu verifikasi admin.'
        );
    }
}
