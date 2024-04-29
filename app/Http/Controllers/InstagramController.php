<?php

namespace App\Http\Controllers;
use App\Models\Instagram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class InstagramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPauseeInstagram($userId)
    {
        $pauseInstagram = Instagram::where('user_id', $userId)
            ->where('status', 'paused')
            ->get();

        return response()->json(['pauseInstagram' => $pauseInstagram]);
    }


    public function getActiveInstagram($userId)
    {
        $activeInstagram = Instagram::where('user_id', $userId)
            ->where('status', 'active')
            ->get();

        return response()->json(['activeInstagram' => $activeInstagram]);
    }
    /**
     * Display a listing of the resource.
     */

    public function toggleStatusInstagram($id)
    {
        $instagram = Instagram::find($id);

        if (!$instagram) {
            return response()->json(['error' => 'Instagram not found'], 404);
        }

        // Toggle the status
        $instagram->status = $instagram->status === 'active' ? 'paused' : 'active';
        $instagram->save();

        $message = $instagram->status === 'active' ? 'Instagram activated successfully' : 'Qrgen paused successfully';

        return response()->json(['message' => $message]);
    }
    /**
     * Show the form for creating a new resource.
     */

    public function getInstagram(User $user)
    {
        $getInstagram = Instagram::where('user_id', $user->id)->get();

        return response()->json(['getInstagram' => $getInstagram]);
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
                'cardname' => 'required|string',
                'username' => 'required|unique:instagrams',
                'image' => 'required|image', // Ensure 'image' is an image file
            ]);

            // Handle file upload for the image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/qrgen/'), $imageName);
                $validatedData['image'] = 'image/qrgen/' . $imageName;
            }

            Instagram::create($validatedData);

            Log::info('Instagram created successfully');

            return response()->json([
                'status' => 200,
                'message' => 'Instagram created successfully',
            ]);
        } catch (\Throwable $e) {
            // Log error
            Log::error('Error creating Instagram', ['error' => $e->getMessage()]);
            // Return internal server error
            return response()->json(['status' => 500, 'error' => 'Internal Server Error'], 500);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instagram  $instagram
     * @return \Illuminate\Http\Response
     */
    public function show(Instagram $instagram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instagram  $instagram
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instagram = Instagram::find($id);

        if (!$instagram) {
            return response()->json(['error' => 'Instagram not found'], 404);
        }

        return response()->json(['instagram' => $instagram]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instagram  $instagram
     * @return \Illuminate\Http\Response
     */
    // Backend: InstagramController@update method

    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'cardname' => 'required|string',
                'username' => 'required|unique:instagrams,username,' . $id,
                'image' => 'image|max:10240', // Maximum file size: 10MB
            ]);

            $instagram = Instagram::findOrFail($id);

            // Update only the fields that are provided in the request
            $instagram->update(array_filter($validatedData));

            // Handle file upload for the image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/qrgen/'), $imageName);
                $instagram->image = 'image/qrgen/' . $imageName;
                $instagram->save();
            }

            Log::info('Instagram updated successfully');

            return response()->json([
                'status' => 200,
                'message' => 'Instagram updated successfully',
            ]);
        } catch (\Throwable $e) {
            // Log error
            Log::error('Error updating Instagram', ['error' => $e->getMessage()]);
            // Return internal server error
            return response()->json(['status' => 500, 'error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instagram  $instagram
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instagram $instagram)
    {
        //
    }
}
