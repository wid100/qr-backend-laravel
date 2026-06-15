<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailVerificationCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicEmailVerificationNotificationController extends Controller
{
    /**
     * Resend verification code for an unverified user (guest-safe).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return response()->json(['status' => 'verification-code-sent']);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['status' => 'already-verified']);
        }

        try {
            app(EmailVerificationCodeService::class)->sendVerificationEmail(
                $user,
                'Smart Card Generator'
            );
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to send verification email. Check mail server settings (SMTP credentials).',
            ], 503);
        }

        return response()->json(['status' => 'verification-code-sent']);
    }
}
