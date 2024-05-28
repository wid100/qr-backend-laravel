<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPauseeWebsite($userId)
    {
        $pauseWebsite = Website::where('user_id', $userId)
            ->where('status', 'paused')
            ->get();

        return response()->json(['pauseWebsite' => $pauseWebsite]);
    }


    public function getActiveWebsite($userId)
    {
        $activeWebsite = Website::where('user_id', $userId)
            ->where('status', 'active')
            ->get();

        return response()->json(['activeWebsite' => $activeWebsite]);
    }
    /**
     * Display a listing of the resource.
     */

    public function toggleStatusWebsite($id)
    {
        $website = Website::find($id);

        if (!$website) {
            return response()->json(['error' => 'Website not found'], 404);
        }

        // Toggle the status
        $website->status = $website->status === 'active' ? 'paused' : 'active';
        $website->save();

        $message = $website->status === 'active' ? 'Website activated successfully' : 'Qrgen paused successfully';

        return response()->json(['message' => $message]);
    }
    /**
     * Show the form for creating a new resource.
     */

    public function getWebsite(User $user)
    {
        $getWebsite = Website::where('user_id', $user->id)->get();

        return response()->json(['getWebsite' => $getWebsite]);
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
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'website_name' => 'required',
                'website_url' => 'required',
                'image' => 'required',
                'status' => 'nullable',
            ]);

            // Handle file upload for the image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/website/'), $imageName);
                $validatedData['image'] = 'image/website/' . $imageName;
            }
            Website::create($validatedData);
            return response()->json([
                'status' => 200,
                'message' => 'Website created successfully',
            ]);
        } catch (\Throwable $e) {
            // Log error
            Log::error('Error creating Website', ['error' => $e->getMessage()]);
            // Return internal server error
            return response()->json(['status' => 500, 'error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $website = Website::find($id);

        if (!$website) {
            return response()->json(['error' => 'website not found'], 404);
        }

        return response()->json(['website' => $website]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Update request received', ['data' => $request->all()]);

            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required',
                'website_name' => 'required',
                'website_url' => 'required',
                'image' => 'required', // Maximum file size: 10MB
            ]);

            Log::info('Data validated', ['validatedData' => $validatedData]);

            $website = Website::findOrFail($id);

            // Handle file upload for the image if present
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/website/'), $imageName);
                $validatedData['image'] = 'image/website/' . $imageName;

                // Delete old image if it exists
                if ($website->image && file_exists(public_path($website->image))) {
                    unlink(public_path($website->image));
                }
            }

            Log::info('Updating website', ['website' => $website]);

            // Update the website with the validated data
            $website->update($validatedData);

            return response()->json([
                'status' => 200,
                'message' => 'Website updated successfully',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json(['status' => 422, 'errors' => $e->errors()]);
        } catch (\Throwable $e) {
            Log::error('Error updating Website', ['error' => $e->getMessage()]);
            return response()->json(['status' => 500, 'error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }







    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $website = Website::find($id);

        if (!$website) {
            return response()->json(['error' => 'website not found'], 404);
        }

        $imagePath = $website->image;
        $website->delete();
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
        return response()->json(['message' => 'website deleted successfully']);
    }
    
}
