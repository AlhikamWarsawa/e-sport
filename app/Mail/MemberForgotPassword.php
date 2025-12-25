<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): self
    {
        return $this
            ->subject('Reset Password Akun Member')
            ->view('emails.member.forgot-password')
            ->with([
                'name' => $this->user->name,
                'email' => $this->user->email,
                'resetUrl' => route(
                    'member.password.index',
                    $this->user->set_password_token
                ),
                'expiredAt' => $this->user->set_password_token_expired_at,
            ]);
    }
}
