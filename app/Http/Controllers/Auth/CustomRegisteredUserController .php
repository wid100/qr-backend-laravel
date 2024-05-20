<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CustomRegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Only log in the user if their email is verified
        if ($user->email_verified_at) {
            Auth::login($user);
            return response()->json([
                'message' => 'Registration successful and logged in',
                'redirect' => route('home'), // Adjust the route as needed
            ], 200);
        }

        return response()->json([
            'message' => 'Registration successful. Please verify your email before logging in.',
        ], 201);
    }
}
