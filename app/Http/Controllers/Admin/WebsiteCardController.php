<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebsiteCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $websites = Website::all();
        // dd($websites);
        return view('admin.website.index', compact('websites'));
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
            $website = Website::find($id);
            return view('admin.website.edit', compact('website'));
        } catch (\Exception $e) {
            Log::error('Error fetching website for editing', ['error' => $e->getMessage()]);
            return redirect()->route('admin.website.index')->with('error', 'Error fetching website for editing.');
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
            $website = Website::findOrFail($id);

            // Validate the request data
            $validatedData = $request->validate([
                'username' => 'required',
                'status' => 'in:active,paused', // Add validation rule for status field
                // Add validation rules for other fields as needed
            ]);

            // Update the website data
            $website->update($validatedData);

            // Check if status field is present in the request
            if ($request->has('status')) {
                // Update the status
                $website->status = $request->input('status');
                $website->save();
            }

            return redirect()->route('admin.website.index')->with('success', 'Website updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Website', ['error' => $e->getMessage()]);
            return redirect()->route('admin.website.index')->with('error', 'Error updating website.');
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
            $website = Website::findOrFail($id);
            $website->delete();

            return redirect()->route('admin.website.index')->with('success', 'Website deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting Website', ['error' => $e->getMessage()]);
            return redirect()->route('admin.website.index')->with('error', 'Error deleting website.');
        }
    }
}