<?php

namespace App\Services;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmailVerificationCodeService
{
    public function issueCode(User $user): string
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $minutes = (int) config('auth.verification.expire', 60);

        $user->forceFill([
            'verify_code' => Hash::make($code),
            'verify_code_expires_at' => Carbon::now()->addMinutes($minutes),
        ])->save();

        return $code;
    }

    public function sendVerificationEmail(User $user, string $appLabel): void
    {
        $code = $this->issueCode($user);

        Mail::to($user->email)->send(
            new VerificationCodeMail($code, $appLabel, $user)
        );
    }

    public function verify(User $user, string $code): bool
    {
        if ($user->hasVerifiedEmail()) {
            return true;
        }

        $normalized = preg_replace('/\D/', '', $code) ?? '';

        if (strlen($normalized) !== 6) {
            return false;
        }

        if (! $user->verify_code || ! $user->verify_code_expires_at) {
            return false;
        }

        if (Carbon::now()->greaterThan($user->verify_code_expires_at)) {
            return false;
        }

        if (! Hash::check($normalized, $user->verify_code)) {
            return false;
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $user->forceFill([
            'verify_code' => null,
            'verify_code_expires_at' => null,
        ])->save();

        return true;
    }
}
