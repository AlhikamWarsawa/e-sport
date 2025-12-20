<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $member;

    public function __construct($member)
    {
        $this->member = $member;
    }

    public function build()
    {
        return $this
            ->subject('Pendaftaran Member Ditolak')
            ->view('emails.member.rejected');
    }
}
