<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email',
                'gender' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string',
                'country_code' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

            $user = User::findOrFail($id);

            $user->fill($validatedData);

            // Handle image upload
            if ($request->hasFile('image')) {
                if ($user->image && file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }

                // Upload new image
                $image = $request->file('image');
                $imageName = uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/user/'), $imageName);
                $user->image = 'image/user/' . $imageName;
            }

            // Save the user with the updated data
            $user->save();

            // Log the update
            Log::info('User updated successfully', ['id' => $user->id]);

            // Return a successful response
            return response()->json([
                'status' => 200,
                'message' => 'User updated successfully',
            ]);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['status' => 422, 'errors' => $e->errors()]);
        } catch (\Throwable $e) {
            // Handle any other errors
            Log::error('Error updating user', ['error' => $e->getMessage()]);
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }
}
