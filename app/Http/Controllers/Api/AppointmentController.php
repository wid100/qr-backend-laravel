<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;

use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentApprovedMail;

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

        // Send the email
        Mail::to($appointment->email)->send(new AppointmentApprovedMail($appointment));

        // Save changes
        $appointment->save();

        return response()->json(['message' => 'Appointment updated and email sent successfully'], 200);
    }
}
