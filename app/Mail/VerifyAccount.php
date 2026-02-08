<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyAccount extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email_data;

    public function __construct($email_data)
    {
        $this->email_data = $email_data;
    }

    public function build()
    {
        return $this->from('no-reply@fmdqgroup.com', 'FMDQ Depository Participant Onboarding Portal')
            ->subject('Verify Your Email')
            ->view('emails.verify_email')
            ->with('email_data', $this->email_data);
    }
}
