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


        $timeSlots = json_decode($appointment->time_slot, true);

        if (is_array($timeSlots) && isset($timeSlots[0])) {
            $timeSlotsArray = explode(',', $timeSlots[0]); // Split the first set of slots into individual items

            // Extract the first slot's start and end times
            $firstSlot = explode(' to ', trim($timeSlotsArray[0] ?? '')); // "09:00 AM to 09:30 AM"

            if (isset($firstSlot[0], $firstSlot[1])) { // Ensure both start and end times exist
                try {
                    $startDateTime = Carbon::createFromFormat('h:i A', $firstSlot[0]); // Start: "09:00 AM"
                    $endDateTime = Carbon::createFromFormat('h:i A', $firstSlot[1]); // End: "09:30 AM"

                    // Add the date to the times
                    $date = $appointment->date ?? null; // Replace with the actual appointment date
                    if ($date) {
                        $startDateTime->setDateFrom(Carbon::parse($date));
                        $endDateTime->setDateFrom(Carbon::parse($date));
                    }

                    // Convert to UTC
                    $appointment['start'] = $startDateTime->format('Ymd\THis');
                    $appointment['end'] =  $endDateTime->format('Ymd\THis');
                } catch (\Exception $e) {
                    throw new \Exception('Error parsing time slots: ' . $e->getMessage());
                }
            } else {
                throw new \Exception('Invalid time slot data structure.');
            }
        } else {
            throw new \Exception('Invalid time slot data.');
        }




        // return response()->json([
        //     'message' => 'Appointment updated successfully',
        //     'status' => 404,
        //     'appointment' => $appointment
        // ]);



        // Send the email
        Mail::to($appointment->email)->send(new AppointmentApprovedMail($appointment));


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
