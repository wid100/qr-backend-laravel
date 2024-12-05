<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentDeclined extends Mailable
{
    use Queueable, SerializesModels;


    public $appointment;
    public $message;

    public function __construct(Appointment $appointment, $message)
    {
        $this->appointment = $appointment;
        $this->message = $message;
    }

    public function build()
    {
        return $this->subject('Your Appointment Has Been Declined')
            ->view('emails.appointment_declined')
            ->with([
                'appointmentId' => $this->appointment->id,
                'declineMessage' => $this->message,
            ]);
    }
}
