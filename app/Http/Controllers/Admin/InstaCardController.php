<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instagram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstaCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instagrams = Instagram::all();
        // dd($websites);
        return view('admin.instagram.index', compact('instagrams'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $instagram = Instagram::find($id);
            return view('admin.instagram.edit', compact('instagram'));
        } catch (\Exception $e) {
            Log::error('Error fetching instagram for editing', ['error' => $e->getMessage()]);
            return redirect()->route('admin.instagram.index')->with('error', 'Error fetching instagram for editing.');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $instagram = Instagram::findOrFail($id);

            // Validate the request data
            $validatedData = $request->validate([
                'username' => 'required',
                'status' => 'in:active,paused', // Add validation rule for status field
                // Add validation rules for other fields as needed
            ]);

            // Update the instagram data
            $instagram->update($validatedData);

            // Check if status field is present in the request
            if ($request->has('status')) {
                // Update the status
                $instagram->status = $request->input('status');
                $instagram->save();
            }

            return redirect()->route('admin.instagram.index')->with('success', 'instagram updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating instagram', ['error' => $e->getMessage()]);
            return redirect()->route('admin.instagram.index')->with('error', 'Error updating instagram.');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $instagram = Instagram::findOrFail($id);
            $instagram->delete();

            return redirect()->route('admin.instagram.index')->with('success', 'instagram deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting instagram', ['error' => $e->getMessage()]);
            return redirect()->route('admin.instagram.index')->with('error', 'Error deleting instagram.');
        }
    }
}