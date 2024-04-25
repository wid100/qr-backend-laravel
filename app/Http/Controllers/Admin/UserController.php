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
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'gender' => 'nullable',
                'country' => 'nullable',
                'city' => 'nullable',
                'address' => 'nullable',
                'country_code' => 'nullable',
                'phone' => 'nullable',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

            $user = User::findOrFail($id);
            // Update user data
            $user->update($validatedData);




            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $imageName = uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/user/'), $imageName);
                $user->image = 'image/user/' . $imageName;
            }



            // Save the changes to the database
            $user->save();

            Log::info('Profile updated successfully', ['id' => $user->id]);

            return response()->json([
                'status' => 200,
                'message' => 'Profile updated successfully',
            ]);
        } catch (\Throwable $e) {
            Log::error(
                'Error updating Profile',
                ['error' => $e->getMessage()]
            );
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User Delete Success');
    }

}
