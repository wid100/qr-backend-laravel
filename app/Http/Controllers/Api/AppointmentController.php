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
use Google\Client;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventAttendee;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AppointmentController extends Controller
{


    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Validation rules based on meeting type
        $rules = [
            'password' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
        ];

        if ($appointment->meeting_type == 1) {
            $rules['meeting_link'] = 'required|string|max:255';
        } elseif ($appointment->meeting_type == 2) {
            $rules['location'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        // Update appointment details
        $appointment->meeting_link = $validated['meeting_link'] ?? null;
        $appointment->meeting_pass = $validated['password'] ?? null;
        $appointment->location = $validated['location'] ?? null;
        $appointment->approval_message = $validated['message'] ?? null;
        $appointment->status = 1; // Approved status

        // Parse time slots and set event start/end times
        $timeSlots = json_decode($appointment->time_slot, true);
        if (is_array($timeSlots) && isset($timeSlots[0])) {
            $timeSlotsArray = explode(',', $timeSlots[0]);
            $firstSlot = explode(' to ', trim($timeSlotsArray[0] ?? ''));
            if (isset($firstSlot[0], $firstSlot[1])) {
                $startDateTime = Carbon::createFromFormat('h:i A', $firstSlot[0])
                    ->setDateFrom(Carbon::parse($appointment->date));
                $endDateTime = Carbon::createFromFormat('h:i A', $firstSlot[1])
                    ->setDateFrom(Carbon::parse($appointment->date));

                $appointment['start'] = $startDateTime->toIso8601String();
                $appointment['end'] = $endDateTime->toIso8601String();
            } else {
                throw new \Exception('Invalid time slot data structure.');
            }
        } else {
            throw new \Exception('Invalid time slot data.');
        }

        // Google Calendar Integration
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->addScope(\Google\Service\Calendar::CALENDAR);
        $service = new \Google\Service\Calendar($client);

        $event = new Event([
            'summary' => 'Appointment: ' . $appointment->id,
            'description' => $appointment->approval_message,
            'start' => [
                'dateTime' => $appointment['start'],
                'timeZone' => 'UTC',
            ],
            'end' => [
                'dateTime' => $appointment['end'],
                'timeZone' => 'UTC',
            ],
            'attendees' => [
                new EventAttendee(['email' => $appointment->email]),
            ],
            'guestsCanModify' => true,
        ]);

        $calendarId = 'primary'; // Or use a specific calendar ID
        $createdEvent = $service->events->insert($calendarId, $event, ['sendUpdates' => 'all']);

        // Send the email
        Mail::to($appointment->email)->send(new AppointmentApprovedMail($appointment));

        // Save changes
        $appointment->save();

        return response()->json(['message' => 'Appointment updated and added to Google Calendar successfully'], 200);
    }





    // public function getAvailableSlots($user_id, $date)
    // {
    //     $parsedDate = Carbon::parse($date)->format('Y-m-d');

    //     $schedules = Schedule::where('user_id', $user_id)
    //         ->where('status', true)
    //         ->get();

    //     $availableSlots = [];

    //     foreach ($schedules as $schedule) {
    //         $dates = json_decode(
    //             $schedule->date,
    //             true
    //         );
    //         $times = json_decode($schedule->time, true);

    //         if (in_array($parsedDate, $dates)) {
    //             $availableSlots = array_merge($availableSlots, $times);
    //         }
    //     }

    //     $availableSlots = array_unique($availableSlots);
    //     return response()->json([
    //         'status' => 200,
    //         'availableSlots' => $availableSlots
    //     ]);
    //     // return response()->json(['availableSlots' => $availableSlots]);
    // }

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
