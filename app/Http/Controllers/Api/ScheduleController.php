<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_name' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required|array',  // Validate as an array
        ]);


        Schedule::create([
            'name' => $validated['appointment_name'],
            'user_id' => $validated['user_id'],
            'date' => $validated['date'],
            'time' => json_encode($validated['time']),  // Encode time array as JSON
        ]);

        return response()->json(['status' => 200, 'message' => 'Appointment created successfully']);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);  // Get the schedule by ID
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
        $validated = $request->validate([
            'schedule_name' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|array',  // Ensure time is an array
        ]);

        $schedule = Schedule::findOrFail($id);

        $schedule->update([
            'name' => $validated['schedule_name'],
            'date' => $validated['date'],
            'time' => json_encode($validated['time']), // Store time as a JSON array
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Schedule updated successfully',
            'schedule' => $schedule
        ]);
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
