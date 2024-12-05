<?php

namespace App\Http\Controllers;

use App\Models\Instagram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            Log::info('Store method called', ['request' => $request->all()]);

            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'instagram_name' => 'required',
                'instagram_username' => 'required',
                'insta_category' => 'nullable',
                'frame_color' => 'nullable',
                'code_color' => 'nullable',
                'image' => 'nullable', // Ensure 'image' is an image file
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed', ['errors' => $validator->errors()]);
                return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
            }

            $validatedData = $validator->validated();

            // Handle file upload for the image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = str_replace(' ', '-', $image->getClientOriginalName());
                $imagePath = public_path('image/qrgen/');
                if (!file_exists($imagePath)) {
                    mkdir($imagePath, 0755, true);
                }
                $image->move($imagePath, $imageName);
                $validatedData['image'] = 'image/qrgen/' . $imageName;
            }

            Log::info('Image uploaded successfully', ['imagePath' => $validatedData['image']]);

            Instagram::create($validatedData);

            Log::info('Instagram entry created successfully');

            return response()->json([
                'status' => 200,
                'message' => 'Instagram entry created successfully',
            ]);
        } catch (\Throwable $e) {
            // Log error details
            Log::error('Error creating Instagram entry', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

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
            Log::info('Update method called', ['request' => $request->all(), 'id' => $id]);

            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'instagram_name' => 'required',
                'instagram_username' => 'required',
                'insta_category' => 'nullable',
                'frame_color' => 'nullable',
                'code_color' => 'nullable',
                'image' => 'nullable',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed', ['errors' => $validator->errors()]);
                return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
            }

            $validatedData = $validator->validated();

            // Find the Instagram entry by ID
            $instagram = Instagram::findOrFail($id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = str_replace(' ', '-', $image->getClientOriginalName());
                $image->move(public_path('image/qrgen/'), $imageName);
                $validatedData['image'] = 'image/qrgen/' . $imageName;

                // Delete old image if it exists
                if ($instagram->image && file_exists(public_path($instagram->image))) {
                    unlink(public_path($instagram->image));
                }
            } else if ($request->image == 'null') {
                unset($validatedData['image']);
            }

            if (isset($validatedData['image'])) {
                Log::info('Image uploaded successfully', ['imagePath' => $validatedData['image']]);
            }

            // Update the Instagram entry
            $instagram->update($validatedData);

            Log::info('Instagram entry updated successfully');

            return response()->json([
                'status' => 200,
                'message' => 'Instagram entry updated successfully',
            ]);
        } catch (\Throwable $e) {
            // Log error details
            Log::error('Error updating Instagram entry', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

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
    public function destroy($id)
    {
        $instagram = Instagram::find($id);

        if (!$instagram) {
            return response()->json(['error' => 'instagram not found'], 404);
        }

        $imagePath = $instagram->image;
        $instagram->delete();
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
        return response()->json(['message' => 'Instagram deleted successfully']);
    }
}
