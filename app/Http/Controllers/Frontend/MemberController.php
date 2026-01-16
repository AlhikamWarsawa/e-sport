<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberProfile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Mail\MemberPendingMail;
use Illuminate\Support\Facades\DB;
use App\Models\MembershipHistory;

class MemberController extends Controller
{
    public function create()
    {
        return view('frontend.member.register');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:150',
            'email'         => 'required|email|max:150|unique:member_profiles,email',
            'phone'         => 'required|string|max:20',
            'birth_date'    => 'nullable|date',
            'address'       => 'nullable|string',
            'city'          => 'nullable|string|max:50',
            'username'      => 'required|string|max:50|unique:member_profiles,membership_id',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'email.unique' => 'Email ini sudah pernah digunakan untuk pendaftaran dan tidak dapat digunakan kembali.',
            'username.unique' => 'Username ini sudah digunakan. Silakan pilih username lain.',
            'payment_proof.mimes' => 'Bukti pembayaran harus berupa JPG, PNG, atau PDF.',
        ]);

        DB::transaction(function () use ($validated) {

            $destination = public_path('images/proof');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file = $validated['payment_proof'];
            $proofName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destination, $proofName);

            $profile = MemberProfile::create([
                'full_name'     => $validated['full_name'],
                'email'         => $validated['email'],
                'phone'         => $validated['phone'],
                'birth_date'    => $validated['birth_date'],
                'address'       => $validated['address'],
                'city'          => $validated['city'],
                'photo'         => null,
                'membership_id' => $validated['username'],
                'payment_proof' => $proofName,
                'status'        => 'pending',
            ]);
            MembershipHistory::create([
                'member_profile_id' => $profile->id,
                'type'        => 'registration',
                'description' => 'Pendaftaran member',
                'status'      => 'paid',
            ]);

            Mail::to($profile->email)->send(new MemberPendingMail($profile));
        });

        return back()->with(
            'success',
            'Pendaftaran berhasil dikirim. Data kamu sedang ditinjau oleh admin.'
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

        $histories = $profile->histories()
            ->latest('created_at')
            ->get();

        return view('frontend.member.profile', compact('profile', 'histories'));
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
