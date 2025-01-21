<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;


class SendEventController extends Controller
{
    public function sendInvitationEmail()
    {

        $event = [
            'id' => 1,
            'title' => 'Annual Company Meeting',
            'description' => 'Join us for the annual meeting to discuss company goals and achievements.',
            'start' => Carbon::parse('2025-02-15 10:00:00')->format('Ymd\THis\Z'), // UTC format
            'end' => Carbon::parse('2025-02-15 12:00:00')->format('Ymd\THis\Z'),   // UTC format
            'location' => 'Company HQ, 123 Business Ave, Cityville',
            'organizer' => 'smaartcard@gmail.com', // Organizer email
            'attendee' => 'mhshakil06@gmail.com',  // Attendee email
        ];



        $icsContent = <<<EOT
        BEGIN:VCALENDAR
        VERSION:2.0
        PRODID:-//Your Company//NONSGML Event//EN
        METHOD:REQUEST
        BEGIN:VEVENT
        UID:event-{$event['id']}@example.com
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


        Mail::send([], [], function ($message) use ($icsContent, $event) {
            $message->to($event['attendee'])
                ->subject("You're Invited: {$event['title']}")
                ->attachData(
                    $icsContent,
                    "event_{$event['id']}.ics",
                    [
                        'mime' => 'text/calendar; charset=utf-8',
                    ]
                )
                ->setBody("Please find the event details attached. We hope to see you there!");
        });

        dd('Invitation sent successfully!');
    }
    public function sendInvitationEmailV1()
    {



        $event = [
            'id' => 1,
            'title' => 'Annual Company Meeting',
            'description' => 'Join us for the annual meeting to discuss company goals and achievements.',
            'start' => Carbon::parse('2025-02-15 10:00:00')->format('Ymd\THis\Z'), // UTC format
            'end' => Carbon::parse('2025-02-15 12:00:00')->format('Ymd\THis\Z'),   // UTC format
            'location' => 'Company HQ, 123 Business Ave, Cityville',
            'organizer' => 'smaartcard@gmail.com', // Organizer email
            'attendee' => 'mehadi.womenindigital@gmail.com',  // Attendee email
        ];





        $icsContent = <<<EOT
        BEGIN:VCALENDAR
        VERSION:2.0
        PRODID:-//Your Company//NONSGML Event//EN
        METHOD:REQUEST
        BEGIN:VEVENT
        UID:event-{$event['id']}@example.com
        DTSTAMP:{$event['start']}
        SUMMARY:{$event['title']}
        DESCRIPTION:{$event['description']}
        DTSTART:{$event['start']}
        DTEND:{$event['end']}
        LOCATION:{$event['location']}
        ORGANIZER;CN=Organizer:mailto:{$event['organizer']}
        ATTENDEE;RSVP=TRUE;CN=Attendee Name:mailto:{$event['attendee']}
        STATUS:CONFIRMED
        SEQUENCE:0
        TRANSP:OPAQUE
        END:VEVENT
        END:VCALENDAR
        EOT;

        Mail::send([], [], function ($message) use ($icsContent, $event) {
            $message->to($event['attendee'])
                ->subject("You're Invited: {$event['title']}")
                ->setBody($icsContent, 'text/calendar; charset=utf-8; method=REQUEST');
        });

        dd('Invitation sent successfully!');
    }
}
