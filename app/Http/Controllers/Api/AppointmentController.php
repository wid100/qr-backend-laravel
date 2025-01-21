<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;

use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentApprovedMail;
use App\Mail\AppointmentDeclined;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AppointmentController extends Controller
{




    public function getAvailableSlots($user_id, $date)
    {
        $parsedDate = Carbon::parse($date)->format('Y-m-d');

        $schedules = Schedule::where('user_id', $user_id)
            ->where('status', true)
            ->get();

        $availableSlots = [];

        foreach ($schedules as $schedule) {
            $dates = json_decode(
                $schedule->date,
                true
            );
            $times = json_decode($schedule->time, true);

            if (in_array($parsedDate, $dates)) {
                $availableSlots = array_merge($availableSlots, $times);
            }
        }

        $availableSlots = array_unique($availableSlots);
        return response()->json([
            'status' => 200,
            'availableSlots' => $availableSlots
        ]);
        // return response()->json(['availableSlots' => $availableSlots]);
    }


    public function index(Request $request, $id)
    {
        $appointments = Appointment::where('user_id', $id)->get();

        return response()->json([
            'status' => 200,
            'appointments' => $appointments,
        ]);
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
            'meeting_type' => 'required'
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
        $appointment = Appointment::find($id);

        // Check if the appointment exists
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        // Return the appointment details as a JSON response
        return response()->json([
            'appointment' => $appointment,
        ], 200);
    }


    public function update(Request $request, $id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);
        // Conditional validation based on meeting_type
        $rules = [
            'password' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
        ];

        if ($appointment->meeting_type == 1) {
            // Meeting type is 1 (online meeting), meeting_link is required, location is nullable
            $rules['meeting_link'] = 'required|string|max:255';
            $rules['location'] = 'nullable|string|max:255';
        } elseif ($appointment->meeting_type == 2) {
            // Meeting type is 2 (physical meeting), location is required, meeting_link is nullable
            $rules['location'] = 'required|string|max:255';
            $rules['meeting_link'] = 'nullable|string|max:255';
        }

        // Validate the incoming data
        $validated = $request->validate($rules);

        // Update appointment details
        $appointment->meeting_link = $validated['meeting_link'];
        $appointment->meeting_pass = $validated['password'] ?? null;
        $appointment->location = $validated['location'] ?? null;
        $appointment->approval_message = $validated['message'] ?? null;
        $appointment->status = 1; // Approved status


        $timeSlots = json_decode($appointment->time_slot, true); // Decode to array
        $timeSlotsArray = explode(',', $timeSlots[0]); // Split into individual slots

        // Extract the first and last slots
        $firstSlot = explode(' to ', $timeSlotsArray[0]); // "09:00 AM to 09:30 AM"
        $lastSlot = explode(' to ', end($timeSlotsArray)); // Last slot "10:00 AM to 10:30 AM"

        // Parse start and end times using Carbon
        $startDateTime = Carbon::createFromFormat('h:i A', $firstSlot[0]); // Start: "09:00 AM"
        $endDateTime = Carbon::createFromFormat('h:i A', $lastSlot[1]); // End: "10:30 AM"

        // Format for iCalendar (UTC format)
        $appointment['start'] = $startDateTime->format('Ymd\THis\Z');
        $appointment['end'] = $endDateTime->format('Ymd\THis\Z');

        // return response()->json([
        //     'message' => 'Appointment updated successfully',
        //     'status' => 404,
        //     'appointment' => $appointment
        // ]);



        // Send the email
        Mail::to($appointment->email)->send(new AppointmentApprovedMail($appointment));

        // $event = [
        //     'id' => 1,
        //     'title' => 'Annual Company Meeting',
        //     'description' => 'Join us for the annual meeting to discuss company goals and achievements.',
        //     'start' => Carbon::parse('2025-02-15 10:00:00')->format('Ymd\THis\Z'), // UTC format
        //     'end' => Carbon::parse('2025-02-15 12:00:00')->format('Ymd\THis\Z'),   // UTC format
        //     'location' => 'Company HQ, 123 Business Ave, Cityville',
        //     'organizer' => 'smaartcard@gmail.com', // Organizer email
        //     'attendee' => $appointment->email,  // Attendee email
        // ];



        // $icsContent = <<<EOT
        // BEGIN:VCALENDAR
        // VERSION:2.0
        // PRODID:-//Your Company//NONSGML Event//EN
        // METHOD:REQUEST
        // BEGIN:VEVENT
        // UID:event-{$event['id']}@example.com
        // SUMMARY:{$event['title']}
        // DESCRIPTION:{$event['description']}
        // DTSTART:{$event['start']}
        // DTEND:{$event['end']}
        // LOCATION:{$event['location']}
        // ORGANIZER;CN=Organizer:mailto:{$event['organizer']}
        // ATTENDEE;RSVP=TRUE:mailto:{$event['attendee']}
        // STATUS:CONFIRMED
        // SEQUENCE:0
        // TRANSP:OPAQUE
        // END:VEVENT
        // END:VCALENDAR
        // EOT;



        // Mail::send('emails.appointment_approved', ['appointment' => $appointment], function ($message) use ($icsContent, $event) {
        //     $message->to('mhshakil06@gmail.com')
        //         ->subject("Appointment Approved Mail ")
        //         ->attachData(
        //             $icsContent,
        //             "event_{$event['id']}.ics",
        //             [
        //                 'mime' => 'text/calendar; charset=utf-8',
        //             ]
        //         );
        // });


        // Save changes
        $appointment->save();

        return response()->json(['message' => 'Appointment updated and email sent successfully'], 200);
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
