<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberProfile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
            'city'          => 'nullable|string|max:50',
            'username'      => 'required|string|max:50|unique:member_profiles,membership_id',
            'payment_proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $file = $request->file('payment_proof');
        $proofName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/proof'), $proofName);

        $profile = MemberProfile::create([
            'full_name'     => $request->full_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'birth_date'    => $request->birth_date,
            'address'       => $request->address,
            'city'          => $request->city,
            'photo'         => null,
            'membership_id' => $request->username,
            'payment_proof' => $proofName,
            'status'        => 'pending',
        ]);

        Mail::to($profile->email)->send(new MemberPendingMail($profile));

        return back()->with(
            'success',
            'Pendaftaran berhasil dikirim. Menunggu verifikasi admin.'
        );
    }

    public function profile()
    {
        $user = Auth::guard('member')->user();

        if (!$user || !$user->memberProfile) {
            abort(403);
        }

        $profile = $user->memberProfile;

        if (!$profile->isApproved()) {
            abort(403, 'Profil hanya dapat diakses setelah pendaftaran disetujui.');
        }

        return view('frontend.member.profile', compact('profile'));
    }

    public function qr()
    {
        $user = Auth::guard('member')->user();

        if (!$user || !$user->memberProfile) {
            abort(403);
        }

        $profile = $user->memberProfile;

        if (!$profile->isApproved()) {
            abort(403, 'QR Code hanya tersedia untuk member yang sudah disetujui.');
        }

        return view('frontend.member.qr', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('member')->user();

        if (!$user || !$user->memberProfile) {
            abort(403);
        }

        $profile = $user->memberProfile;

        $data = $request->validate([
            'full_name' => 'required|string|max:150',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
            'city'      => 'nullable|string|max:50',
            'photo'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {

            if (
                $profile->photo &&
                File::exists(public_path('images/profile/' . $profile->photo))
            ) {
                File::delete(public_path('images/profile/' . $profile->photo));
            }

            $photoName = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('images/profile'), $photoName);

            $data['photo'] = $photoName;
        }

        $profile->update($data);

        return redirect()
            ->route('member.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $user = Auth::guard('member')->user();

        if (!$user || !$user->memberProfile) {
            abort(403);
        }

        $profile = $user->memberProfile;

        $data = $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            // hapus foto lama
            if ($profile->photo && File::exists(public_path('images/profile/' . $profile->photo))) {
                File::delete(public_path('images/profile/' . $profile->photo));
            }

            $photoName = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('images/profile'), $photoName);

            $profile->update([
                'photo' => $photoName,
            ]);
        }

        return redirect()
            ->route('member.profile')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }
}
