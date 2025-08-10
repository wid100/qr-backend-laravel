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
            'start' => Carbon::parse('2025-05-11 11:38:00')->format('Ymd\THis\Z'), // UTC format
            'end' => Carbon::parse('2025-05-11 11:55:00')->format('Ymd\THis\Z'),   // UTC format
            'location' => 'Womenindigital, 123 Business Ave, Cityville',
            'organizer' => 'smaartcard@gmail.com', // Organizer email
            'attendee' => 'Nila.cse01@gmail.com',  // Attendee email
        ];



        $icsContent = <<<EOT
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Laravel//EN
METHOD:REQUEST
BEGIN:VEVENT
UID:{$event['id']}@{$_SERVER['HTTP_HOST']}
SUMMARY:{$event['title']}
DESCRIPTION:{$event['description']}
DTSTART:{$event['start']}
DTEND:{$event['end']}
LOCATION:{$event['location']}
ORGANIZER:{$event['organizer']}
ATTENDEE:{$event['attendee']}
STATUS:CONFIRMED
SEQUENCE:0
TRANSP:OPAQUE
BEGIN:VALARM
TRIGGER:-PT10M
DESCRIPTION:Reminder
ACTION:DISPLAY
END:VALARM
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
}
