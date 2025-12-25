<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberPasswordController extends Controller
{
    protected function getUserByValidToken(string $token): User
    {
        $user = User::where('set_password_token', $token)->first();

        if (!$user) {
            abort(404);
        }

        if (
            $user->set_password_token_expired_at &&
            Carbon::parse($user->set_password_token_expired_at)->isPast()
        ) {
            abort(403, 'Token set password sudah kadaluarsa.');
        }

        if (empty($user->member_id) || $user->role === 'admin') {
            abort(403);
        }

        return $user;
    }

    public function index(string $token)
    {
        $user = $this->getUserByValidToken($token);

        return view('frontend.member.set-password', [
            'token' => $token,
            'email' => $user->email,
        ]);
    }

    public function store(Request $request, string $token)
    {
        $data = $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = $this->getUserByValidToken($token);

        $user->update([
            'password' => Hash::make($data['password']),
            'set_password_token' => null,
            'set_password_token_expired_at' => null,
        ]);

        Auth::guard('member')->login($user);
        $request->session()->regenerate();

        return redirect()->route('member.profile');
    }

    public function sendForgotPasswordLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)
            ->whereNotNull('member_id')
            ->where('role', '!=', 'admin')
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan atau bukan akun member.',
            ]);
        }

        $user->update([
            'set_password_token' => Str::uuid(),
            'set_password_token_expired_at' => now()->addMinutes(30),
        ]);

        \Mail::to($user->email)->send(
            new \App\Mail\MemberForgotPassword($user)
        );

        return back()->with('success', 'Link reset password telah dikirim ke email.');
    }
}
