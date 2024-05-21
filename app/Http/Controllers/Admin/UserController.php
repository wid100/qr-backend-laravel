<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', 2)->get();

        return view('admin.user.index', compact('users'));
    }
    public function update(Request $request, $id)
    {
        try {
            // Validation
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'gender' => 'nullable',
                'country' => 'nullable',
                'city' => 'nullable',
                'address' => 'nullable',
                'country_code' => 'nullable',
                'phone' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

            // Find user by ID
            $user = User::findOrFail($id);

            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($user->image && file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }

                // Upload new image
                $image = $request->file('image');
                $imageName = uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/user/'), $imageName);
                $validatedData['image'] = 'image/user/' . $imageName;
            }


            // Update user data
            $user->update($validatedData);

            // Save the changes to the database
            $user->save();

            Log::info('Profile updated successfully', ['id' => $user->id]);

            return response()->json([
                'status' => 200,
                'message' => 'Profile updated successfully',
            ]);
        } catch (\Throwable $e) {
            Log::error('Error updating profile', ['error' => $e->getMessage()]);
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User Delete Success');
    }

}
