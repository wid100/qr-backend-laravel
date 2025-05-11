<?php

namespace App\Http\Controllers\Api;

use App\Models\Schedule;
use App\Models\Appointment;
use App\Mail\AppointmentDeclined;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Calendar as GoogleCalendarService;
use Google\Service\Calendar\Event as GoogleCalendarEvent;
use Google\Service\Calendar\EventDateTime as GoogleCalendarEventDateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentApprovedMail;
use DateTime;
use DateTimeZone;

class AppointmentController extends Controller
{


    public function addToGoogleCalendar(Appointment $appointment)
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->addScope(GoogleCalendarService::CALENDAR);

        // Laravel এর সেশন ব্যবহার করুন
        if (!session()->has('access_token')) {
            $authUrl = $client->createAuthUrl();
            return redirect()->away($authUrl);
        } else {
            $client->setAccessToken(session('access_token'));
        }

        $service = new GoogleCalendarService($client);

        try {
            // তারিখ এবং সময় একত্রিত করে DateTime অবজেক্ট তৈরি করুন
            $startDateTime = Carbon::parse($appointment->date . ' ' . $appointment->start_time, 'Asia/Dhaka')->setTimezone('UTC');
            // Google Calendar API UTC টাইম ফরম্যাটে আশা করে
            $endDateTime = (clone $startDateTime)->addHour(); // উদাহরণস্বরূপ, ১ ঘণ্টার অ্যাপয়েন্টমেন্ট

            $event = new GoogleCalendarEvent([
                'summary' => 'Appointment with ' . $appointment->first_name . ' ' . $appointment->last_name,
                'location' => $appointment->location ?? 'Online',
                'description' => $appointment->message ?? 'Appointment scheduled.',
                'start' => [
                    'dateTime' => $startDateTime->format(DateTime::RFC3339),
                    'timeZone' => 'UTC',
                ],
                'end' => [
                    'dateTime' => $endDateTime->format(DateTime::RFC3339),
                    'timeZone' => 'UTC',
                ],
                'reminders' => [
                    'useDefault' => false,
                    'overrides' => [
                        ['method' => 'popup', 'minutes' => 10],
                    ],
                ],
            ]);

            $calendarId = 'primary';
            $googleEvent = $service->events->insert($calendarId, $event);

            // Optionally, আপনি Google Calendar ইভেন্টের আইডি আপনার ডাটাবেসে সংরক্ষণ করতে পারেন
            // $appointment->google_calendar_event_id = $googleEvent->getId();
            // $appointment->save();

            return back()->with('success', 'Appointment added to Google Calendar.');
        } catch (\Google\Service\Exception $e) {
            error_log('Google Calendar API error: ' . $e->getMessage());
            return back()->with('error', 'Failed to add event to Google Calendar: ' . $e->getMessage());
        } catch (\Exception $e) {
            error_log('General error: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while adding to Google Calendar.');
        }
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $rules = [
            'password' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
        ];

        if ($appointment->meeting_type == 1) {
            $rules['meeting_link'] = 'required|string|max:255';
            $rules['location'] = 'nullable|string|max:255';
        } elseif ($appointment->meeting_type == 2) {
            $rules['location'] = 'required|string|max:255';
            $rules['meeting_link'] = 'nullable|string|max:255';
        }

        $validated = $request->validate($rules);

        $appointment->meeting_link = $validated['meeting_link'];
        $appointment->meeting_pass = $validated['password'] ?? null;
        $appointment->location = $validated['location'] ?? null;
        $appointment->approval_message = $validated['message'] ?? null;
        $appointment->status = 1;

        // তারিখ এবং সময় একত্রিত করে Carbon অবজেক্ট তৈরি করুন
        $startTime = Carbon::parse($appointment->date . ' ' . $appointment->start_time, 'Asia/Dhaka');
        $endTime = (clone $startTime)->addHour();

        $appointment->start = $startTime->format('Y-m-d H:i:s');
        $appointment->end = $endTime->format('Y-m-d H:i:s');

        $icsContent = $this->generateIcsContent($appointment);

        $appointment->save();

        Mail::to($appointment->email)->send(new AppointmentApprovedMail($appointment, $icsContent));

        return response()->json(['message' => 'Appointment updated successfully and email sent.'], 200);
    }

    /**
     * Generate ICS content with RSVP options (Yes/No/Maybe)
     *
     * @param Appointment $appointment
     * @return string
     */
    private function generateIcsContent(Appointment $appointment)
    {
        $startDateTime = new DateTime($appointment->start, new DateTimeZone('UTC'));
        $endDateTime = new DateTime($appointment->end, new DateTimeZone('UTC'));

        $event = [
            'id' => $appointment->id,
            'title' => 'Appointment Approved',
            'description' => $appointment->approval_message ?? 'Your appointment has been approved.',
            'start' => $startDateTime->format('Ymd\THis\Z'),
            'end' => $endDateTime->format('Ymd\THis\Z'),
            'location' => $appointment->location ?? '',
            'organizer' => 'CN=Organizer:mailto:' . config('mail.from.address'), // Use configured email
            'attendee' => 'RSVP=TRUE;CN=' . $appointment->email . ':mailto:' . $appointment->email,
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

        return $icsContent;
    }





    public function getAvailableSlots($user_id, $date)
    {
        $parsedDate = Carbon::parse($date)->format('Y-m-d');

        $schedules = Schedule::where('user_id', $user_id)
            ->where('status', true)
            ->get();

        $availableSlots = [];

        foreach ($schedules as $schedule) {
            $dates = json_decode($schedule->date, true);
            $times = json_decode($schedule->time, true);

            if (in_array($parsedDate, $dates)) {
                foreach ($times as $time) {
                    // Store time and name together for each schedule slot
                    $availableSlots[] = [
                        'name' => $schedule->name,  // Name associated with the schedule
                        'time' => $time,            // Time slot
                        'date' => $parsedDate       // Date for reference
                    ];
                }
            }
        }

        // Removing duplicate time slots if necessary
        $availableSlots = array_map("unserialize", array_unique(array_map("serialize", $availableSlots)));

        return response()->json([
            'status' => 200,
            'availableSlots' => $availableSlots
        ]);
    }





    public function index($userId)
    {
        $appointments = Appointment::where('user_id', $userId)
            ->with('scheduleArea') // Include related schedule_area data
            ->get();

        return response()->json(['appointments' => $appointments]);
    }




    public function store(Request $request)
    {
        // Decode time_slots if sent as a JSON string
        if ($request->has('time_slots') && is_string($request->time_slots)) {
            $request->merge(['time_slots' => json_decode($request->time_slots, true)]);
        }

        $request->validate([
            'date' => 'required|date',
            'time_slots' => 'required|array',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'user_id' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'meeting_app' => 'nullable|string',
            'message' => 'nullable|string',
            'meeting_type' => 'required',
            'meeting_area' => 'nullable|string',
        ]);

        Appointment::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'time_slot' => json_encode($request->time_slots),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'meeting_app' => $request->meeting_app,
            'message' => $request->message,
            'meeting_type' => $request->meeting_type,
            'appointment_area' => $request->meeting_area,
        ]);

        return response()->json(
            [
                'message' => 'Appointment created successfully',
                'status' => 200,
            ],
        );
    }


    public function show($id)
    {
        // Fetch the appointment by ID
        $appointment = Appointment::with('scheduleArea')->find($id);

        // Check if the appointment exists
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        // Return the appointment details as a JSON response
        return response()->json([
            'appointment' => $appointment,
        ], 200);
    }



    public function decline($id, Request $request)
    {
        // Validate the message (ensure it's provided)
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Update the appointment status to "2" (declined)
        $appointment->status = 2;

        // Save the decline message from the request
        $appointment->decline_message = $validated['message'];

        // Save the updated appointment status and message
        $appointment->save();

        // Send email to the user with the decline message
        $this->sendDeclineEmail($appointment, $validated['message']);

        // Return a success response
        return response()->json(['message' => 'Appointment declined and email sent successfully'], 200);
    }

    protected function sendDeclineEmail(Appointment $appointment, $message)
    {
        // Get the user associated with the appointment (assuming user is related to the appointment)
        $appointment_email = $appointment->email;

        // Send the decline email with the message
        Mail::to($appointment_email)->send(new AppointmentDeclined($appointment, $message));
    }


    public function destroy($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::find($id);

        // Check if the appointment exists
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found.'], 404);
        }

        // Delete the appointment
        $appointment->delete();

        // Return success response
        return response()->json(['message' => 'Appointment deleted successfully.'], 200);
    }
}
