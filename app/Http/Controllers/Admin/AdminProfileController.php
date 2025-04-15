<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class AdminProfileController extends Controller
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
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        return view('admin.profile.edit', compact('user'));
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
        // Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'gender' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',   // Image validation
        ]);

        // Find the user to update
        $user = User::findOrFail($id);

        // Update user fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->phone = $request->phone;

        // Handle image upload if a new image is uploaded
        $image = $request->file('image');
        if ($image) {
            // Delete the old image if it exists
            if ($user->image) {
                $oldImagePath = public_path('storage/user/' . $user->image);
                if (File::exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $reviewDirectory = public_path('storage/user');
            File::makeDirectory($reviewDirectory, 0755, true, true);

            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $uniqueName = $originalName . '_' . Str::random(20) . '_' . uniqid() . '.webp';

            // Save the new image as webp
            Image::make($image)->save(public_path('storage/user/' . $uniqueName), 90, 'webp');

            $userImagePath = 'storage/user/' . $uniqueName;

            $user->image = $userImagePath;
        }

        // Save the updated user data
        $user->save();

        // Redirect back with success message
        return redirect()->route('admin.profile.edit', $id)
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
