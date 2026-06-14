<?php

namespace App\Modules\HealthCard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\HealthCard\Notifications\HealthCardResetPassword;
use App\Modules\HealthCard\Notifications\HealthCardVerifyEmail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class HealthCardAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        $remember = $request->boolean('remember', false);

        if (! Auth::attempt([
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ], $remember)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        Auth::logout();

        if (! $user->email_verified_at) {
            return response()->json([
                'message'     => 'Please verify your email address before logging in',
                'redirect_to' => '/verify',
            ], 403);
        }

        $token = $user->createToken('health-card-auth')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user'    => $user,
            'token'   => $token,
        ], 200);
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'patient',
        ]);

        try {
            $user->notify(new HealthCardVerifyEmail());
        } catch (\Throwable $e) {
            report($e);
        }

        $token = $user->createToken('health-card-auth')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful. Please verify your email address.',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();
        if ($token) {
            $token->delete();
        }

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return response()->json([
                'message' => 'If that email address exists, we have sent a password reset link.',
            ], 200);
        }

        $token = Password::createToken($user);

        try {
            $user->notify(new HealthCardResetPassword($token));
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to send password reset email at this time. Please try again later.',
            ], 503);
        }

        return response()->json([
            'message' => 'Password reset link sent to your email.',
        ], 200);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token'                 => ['required', 'string'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password'       => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json([
            'message' => 'Password has been reset successfully.',
        ], 200);
    }

    public function resendVerificationEmail(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified.',
            ], 200);
        }

        try {
            $user->notify(new HealthCardVerifyEmail());
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to send verification email at this time. Please try again later.',
            ], 503);
        }

        return response()->json([
            'message' => 'Verification link sent.',
        ], 200);
    }
}
