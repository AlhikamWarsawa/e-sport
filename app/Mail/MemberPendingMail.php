<?php

namespace App\Mail;

use App\Models\MemberProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberPendingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $member;

    public function __construct(MemberProfile $member)
    {
        $this->member = $member;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Anda Sedang Ditinjau')
            ->view('emails.member_pending');
    }
}
