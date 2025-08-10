<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{


    public function index($id)
    {
        $schedule = Schedule::where('user_id', $id)
            ->get();
        return response()->json(['Schedule' => $schedule]);
    }


    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'appointment_name' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|array',  // Change this to 'date'
            'date.*' => 'date',  // Validate each date in the array
            'time' => 'required|array',  // Validate time as an array
            'time.*' => 'string',  // Validate each time slot as a string
        ]);

        // Store the schedule in the database
        Schedule::create([
            'name' => $validated['appointment_name'],
            'user_id' => $validated['user_id'],
            'date' => json_encode($validated['date']),  // Use 'date' here if you change the validation
            'time' => json_encode($validated['time']),  // Encode time array as JSON
        ]);

        return response()->json(['status' => 200, 'message' => 'Schedule created successfully']);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return response()->json([
            'status' => 200,
            'schedule' => $schedule
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the schedule by ID
        $schedule = Schedule::findOrFail($id);

        // Validate the input
        $validated = $request->validate([
            'appointment_name' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|array',
            'date.*' => 'date',
            'time' => 'required|array',
            'time.*' => 'string',
        ]);

        // Update the schedule in the database
        $schedule->update([
            'name' => $validated['appointment_name'],
            'user_id' => $validated['user_id'],
            'date' => json_encode($validated['date']),
            'time' => json_encode($validated['time']),
        ]);

        return response()->json(['status' => 200, 'message' => 'Schedule updated successfully']);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Schedule deleted successfully',
        ]);
    }
}
