<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email_data;

    public function __construct($email_data)
    {
        $this->email_data = $email_data;
    }

    public function build()
    {
        return $this->from('hello@travaiq.com', 'Travaiq')
            ->subject('Welcome Onboard')
            ->view('emails.welcome_email')
            ->with('email_data', $this->email_data);
    }
}
