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

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        // Event details for fallback or additional context
        $event = [
            'id' => $this->appointment->id,
            'title' => 'Appointment Approved',
            'description' => $this->appointment->approval_message,
            'start' => $this->appointment->start, // UTC format
            'end' => $this->appointment->end,   // UTC format
            'location' => $this->appointment->location,
            'organizer' => 'smaartcard@gmail.com', // Organizer email
            'attendee' => $this->appointment->email,  // Attendee email
        ];

        // Optional: ICS content generation
        $icsContent = <<<EOT
    BEGIN:VCALENDAR
    VERSION:2.0
    PRODID:-//Your Company//NONSGML Event//EN
    METHOD:REQUEST
    BEGIN:VEVENT
    UID:event-{$event['id']}@gmail.com
    SUMMARY:{$event['title']}
    DESCRIPTION:{$event['description']}
    DTSTART:{$event['start']}
    DTEND:{$event['end']}
    LOCATION:{$event['location']}
    ORGANIZER;CN=Organizer:mailto:{$event['organizer']}
    ATTENDEE;RSVP=TRUE:mailto:{$event['attendee']}
    STATUS:CONFIRMED
    SEQUENCE:0
    TRANSP:OPAQUE
    END:VEVENT
    END:VCALENDAR
    EOT;

        // Build the email
        $email = $this->view('emails.appointment_approved')
            ->with(['appointment' => $this->appointment]);

        // Attach the ICS file only if required
        if ($this->appointment->meeting_type == 1 || $this->appointment->meeting_type == 2) {
            $email->attachData(
                $icsContent,
                "appointment_{$this->appointment->id}.ics",
                [
                    'mime' => 'text/calendar; charset=utf-8',
                ]
            );
        }

        return $email;
    }
}
