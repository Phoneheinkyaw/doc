<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class DoctrPasswordResetMail extends Mailable
{
    public $email;
    public $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $resetUrl)
    {
        $this->email = $email;
        $this->resetUrl = $resetUrl;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Password Reset Request')
                    ->view('mail.doctor_password_reset')
                    ->with([
                        'resetUrl' => $this->resetUrl,
                        'email' => $this->email,
                    ]);
    }
}
