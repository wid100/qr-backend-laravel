<?php

namespace App\Http\Controllers\Api;

use App\Models\ScheduleArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleAreaController extends Controller
{

    public function index($user_id)
    {
        $scheduleAreas = ScheduleArea::where('user_id', $user_id)->get();

        return response()->json($scheduleAreas, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $scheduleArea = ScheduleArea::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? true,
        ]);

        return response()->json(
            [
                'message' => 'Schedule Area created successfully',
                'status' => 200,
            ],
        );
    }

    // Edit an existing schedule area
    public function edit($id)
    {
        $scheduleArea = ScheduleArea::find($id);

        if (!$scheduleArea) {
            return response()->json(['message' => 'Schedule Area not found'], 404);
        }

        return response()->json($scheduleArea, 200);
    }

    // Update an existing schedule area
    public function update(Request $request, $id)
    {
        $scheduleArea = ScheduleArea::find($id);

        if (!$scheduleArea) {
            return response()->json(['message' => 'Schedule Area not found'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $scheduleArea->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(
            [
                'message' => 'Schedule Area created successfully',
                'status' => 200,
            ],
        );
    }

    // Delete a schedule area
    public function destroy($id)
    {
        $scheduleArea = ScheduleArea::find($id);

        if (!$scheduleArea) {
            return response()->json(['message' => 'Schedule Area not found'], 404);
        }

        $scheduleArea->delete();

        return response()->json(['message' => 'Schedule Area deleted successfully'], 200);
    }
}
