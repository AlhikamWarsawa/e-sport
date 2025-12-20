<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberApprovedMail extends Mailable
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
            ->subject('Pendaftaran Member Disetujui')
            ->view('emails.member.approved');
    }
}
