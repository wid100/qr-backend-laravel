<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailVerificationCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerifyEmailCodeController extends Controller
{
    public function store(Request $request, EmailVerificationCodeService $service): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'code' => ['required', 'string', 'min:6', 'max:6'],
        ]);

        $email = $validated['email'] ?? $request->user()?->email;

        if (! $email) {
            throw ValidationException::withMessages([
                'email' => ['Email address is required.'],
            ]);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'code' => ['Invalid verification code.'],
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => 'already-verified',
                'message' => 'Email is already verified.',
            ]);
        }

        if (! $service->verify($user, $validated['code'])) {
            throw ValidationException::withMessages([
                'code' => ['Invalid or expired verification code.'],
            ]);
        }

        return response()->json([
            'status' => 'verified',
            'message' => 'Email verified successfully.',
        ]);
    }
}
