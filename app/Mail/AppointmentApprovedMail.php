<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $icsContent;

    public function __construct(Appointment $appointment, string $icsContent)
    {
        $this->appointment = $appointment;
        $this->icsContent = $icsContent;
    }

    // public function build()
    // {
    //     // Build the email
    //     $email = $this->view('emails.appointment_approved')
    //         ->with(['appointment' => $this->appointment]);

    //     // Attach the ICS file that was generated in the update() method
    //     if ($this->appointment->meeting_type == 1 || $this->appointment->meeting_type == 2) {
    //         $email->attachData(
    //             $this->icsContent,  // ICS content passed from update method
    //             "appointment_{$this->appointment->id}.ics",
    //             [
    //                 'mime' => 'text/calendar; charset=utf-8',
    //             ]
    //         );
    //     }

    //     return $email;
    // }



    public function build()
    {
        return $this->subject('Appointment Approved')
            ->view('emails.appointment_approved') // আপনার ইমেইল টেমপ্লেট
            ->attachData($this->icsContent, 'appointment.ics', [
                'mime' => 'text/calendar; charset=utf-8; method=REQUEST',
            ]);
    }
}
