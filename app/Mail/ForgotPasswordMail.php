<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email_data;

    /**
     * Create a new message instance.
     */
    public function __construct($email_data)
    {
        $this->email_data = $email_data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->to($this->email_data['email'])
            ->subject('Reset Password')
            ->from('hello@travaiq.com', 'Travaiq')
            ->view('emails.forgetpassword')
            ->with('email_data', $this->email_data);
    }
}
