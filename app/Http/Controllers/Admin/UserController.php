<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', 2)->get();

        return view('admin.user.index', compact('users'));
    }

    public function block()
    {
        $users = User::where('role_id', 4)->get();
        return view('admin.user.block', compact('users'));
    }



    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }




    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'gender' => 'nullable',
            'country' => 'nullable',
            'city' => 'nullable',
            'address' => 'nullable',
            'phone' => 'nullable',
            'country_code' => 'nullable',
            
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
        ];

        $image = $request->file('image');
        if ($image) {
            if ($user->image) {
                $filePath = public_path('storage/user/' . $user->image);
                if ($filePath) {
                    unlink($filePath);
                }
            }

            $reviewDirectory = public_path('storage/user');
            File::makeDirectory($reviewDirectory, 0755, true, true);

            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $uniqueName = $originalName . '_' . Str::random(20) . '_' . uniqid() . '.' . '.webp';
            Image::make($image)->save('storage/user/' . $uniqueName, 90, 'webp');

            $data['image'] = $uniqueName;
        }
        $user->update($data);


        // Redirect back with success message
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }



    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User Delete Success');
    }
}
