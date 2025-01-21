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


        $event = [
            'id' => 1,
            'title' => 'Appointment Approved',
            'description' => $this->appointment->approval_message,
            // 'start' => Carbon::parse('2025-02-15 10:00:00')->format('Ymd\THis\Z'), // UTC format
            'start' => $this->appointment->start, // UTC format
            'end' => $this->appointment->end,   // UTC format
            'location' => $this->appointment->location,
            'organizer' => 'smaartcard@gmail.com', // Organizer email
            'attendee' => $this->appointment->email,  // Attendee email
        ];




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

        return $this->view('emails.appointment_approved')
            ->with([
                'appointment' => $this->appointment,
            ])
            ->attachData(
                $icsContent,
                "appointment_{$this->appointment->id}.ics",
                [
                    'mime' => 'text/calendar; charset=utf-8',
                ]
            );
    }
}
