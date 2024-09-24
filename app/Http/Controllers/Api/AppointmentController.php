<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;

use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{


    public function getAvailableSlots(Request $request)
    {
        $user_id = $request->query('user_id');
        $date = $request->query('date');

        $scheduledSlots = Schedule::where('user_id', $user_id)
            ->whereDate('date', $date)
            ->pluck('time')
            ->map(function ($time) {
                return json_decode($time, true);
            })
            ->flatten()
            ->toArray();

        return response()->json([
            'status' => 200,
            'timeSlots' => array_values($scheduledSlots),
        ]);
    }




    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time_slot' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Create appointment
        Appointment::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Appointment created successfully'], 200);
    }
}
