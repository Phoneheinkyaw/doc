<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class DoctorWelcomeMail extends Mailable
{
    protected $doctor;
    protected $url;

    /**
     * Create a new message instance.
     */
    public function __construct($doctor, $url)
    {
        $this->doctor = $doctor; // Correct assignment
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Doctor Welcome Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.welcome_doctor',
            with: ['doctor' => $this->doctor,
                   'url' => $this->url],
        );
    }
}
