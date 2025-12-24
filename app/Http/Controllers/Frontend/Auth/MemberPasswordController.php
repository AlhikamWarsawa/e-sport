<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberPasswordController extends Controller
{
    public function index(string $token)
    {
        $user = User::query()
            ->where('set_password_token', $token)
            ->first();

        if (!$user) {
            abort(404);
        }

        if ($user->set_password_token_expired_at && Carbon::parse($user->set_password_token_expired_at)->isPast()) {
            return redirect()
                ->route('member.login')
                ->withErrors(['token' => 'Link set password sudah kadaluarsa. Silakan minta link baru.']);
        }

        if (empty($user->member_id) || ($user->role ?? null) === 'admin') {
            abort(403);
        }

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

        $user = User::query()
            ->where('set_password_token', $token)
            ->first();

        if (!$user) {
            return redirect()
                ->route('member.login')
                ->withErrors(['token' => 'Link set password tidak valid.']);
        }

        if ($user->set_password_token_expired_at && Carbon::parse($user->set_password_token_expired_at)->isPast()) {
            return redirect()
                ->route('member.login')
                ->withErrors(['token' => 'Link set password sudah kadaluarsa. Silakan minta link baru.']);
        }

        if (empty($user->member_id) || ($user->role ?? null) === 'admin') {
            abort(403);
        }

        $user->password = Hash::make($data['password']);
        $user->set_password_token = null;
        $user->set_password_token_expired_at = null;
        $user->save();

        Auth::guard('member')->login($user);
        $request->session()->regenerate();

        return redirect()->route('member.profile');
    }
}
