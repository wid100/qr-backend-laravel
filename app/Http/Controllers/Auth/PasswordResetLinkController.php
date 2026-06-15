<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PasswordResetCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Send a 6-digit password reset code to the user's email.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return response()->json([
                'status' => 'reset-code-sent',
                'message' => 'If that email address exists, we have sent a password reset code.',
            ]);
        }

        try {
            app(PasswordResetCodeService::class)->sendResetEmail(
                $user,
                'Smart Card Generator'
            );
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to send password reset email at this time. Please try again later.',
            ], 503);
        }

        return response()->json([
            'status' => 'reset-code-sent',
            'message' => 'Password reset code sent to your email.',
        ]);
    }
}
