<?php

namespace App\Modules\HealthCard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailVerificationCodeService;
use App\Services\PasswordResetCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            app(EmailVerificationCodeService::class)->sendVerificationEmail(
                $user,
                'Smart Health Card'
            );
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
                'message' => 'If that email address exists, we have sent a password reset code.',
                'status'  => 'reset-code-sent',
            ], 200);
        }

        try {
            app(PasswordResetCodeService::class)->sendResetEmail($user);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to send password reset email at this time. Please try again later.',
            ], 503);
        }

        return response()->json([
            'message' => 'Password reset code sent to your email.',
            'status'  => 'reset-code-sent',
        ], 200);
    }

    public function verifyResetCode(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'code'  => ['required', 'string', 'min:6', 'max:6'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'code' => ['Invalid or expired reset code.'],
            ]);
        }

        $valid = app(PasswordResetCodeService::class)->verifyCode(
            $validated['email'],
            $validated['code']
        );

        if (! $valid) {
            throw ValidationException::withMessages([
                'code' => ['Invalid or expired reset code.'],
            ]);
        }

        return response()->json([
            'message' => 'Reset code verified.',
            'status'  => 'code-verified',
        ], 200);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code'                  => ['required', 'string'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'code' => ['Invalid or expired reset code.'],
            ]);
        }

        $reset = app(PasswordResetCodeService::class)->resetPassword(
            $user,
            $validated['code'],
            $validated['password']
        );

        if (! $reset) {
            throw ValidationException::withMessages([
                'code' => ['Invalid or expired reset code.'],
            ]);
        }

        return response()->json([
            'message' => 'Password has been reset successfully.',
            'status'  => 'password-reset',
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
            app(EmailVerificationCodeService::class)->sendVerificationEmail(
                $user,
                'Smart Health Card'
            );
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to send verification email. Check mail server settings (SMTP credentials).',
            ], 503);
        }

        return response()->json([
            'message' => 'Verification code sent.',
            'status'  => 'verification-code-sent',
        ], 200);
    }

    /**
     * Resend verification code by email (no auth — for /verify page).
     */
    public function resendVerificationEmailPublic(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return response()->json([
                'status'  => 'verification-code-sent',
                'message' => 'If that email is registered, a verification code has been sent.',
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status'  => 'already-verified',
                'message' => 'Email already verified.',
            ]);
        }

        try {
            app(EmailVerificationCodeService::class)->sendVerificationEmail(
                $user,
                'Smart Health Card'
            );
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to send verification email. Check mail server settings (SMTP credentials).',
            ], 503);
        }

        return response()->json([
            'status'  => 'verification-code-sent',
            'message' => 'Verification code sent.',
        ]);
    }
}
