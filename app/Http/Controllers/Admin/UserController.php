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
            'gender' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->fill($validatedData);

        if ($request->has('email_verified_at')) {
            $user->email_verified_at = now();
        } else {
            $user->email_verified_at = null;
        }

        if ($request->has('role_id')) {
            $user->role_id = 4;
        } else {
            $user->role_id = 2;
        }

        $user->save();

        // Redirect back with success message
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }



    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User Delete Success');
    }
}
