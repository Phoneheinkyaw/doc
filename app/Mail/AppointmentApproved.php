<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Mail\Mailable;

class AppointmentApproved extends Mailable
{
    public $appointment;

    /**
     * Create a new message instance.
     * @param  \App\Models\Appointment  $appointment
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Appointment is Approved')
            ->markdown('mail.approve_mail')
            ->with([
                'patientName' => $this->appointment->patient->name,
                'doctorName' => $this->appointment->doctor->name,
                'appointmentDate' => $this->appointment->appointment_date,
            ]);
    }
}
