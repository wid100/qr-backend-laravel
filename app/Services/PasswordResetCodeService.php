<?php

namespace App\Services;

use App\Mail\PasswordResetCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetCodeService
{
    public function issueCode(User $user): string
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $table = config('auth.passwords.users.table', 'password_resets');

        DB::table($table)->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($code),
                'created_at' => Carbon::now(),
            ]
        );

        return $code;
    }

    public function sendResetEmail(User $user, string $appLabel = 'Smart Card Generator'): void
    {
        $code = $this->issueCode($user);

        Mail::to($user->email)->send(
            new PasswordResetCodeMail($code, $appLabel, $user)
        );
    }

    public function verifyCode(string $email, string $code): bool
    {
        return $this->findValidRecord($email, $code) !== null;
    }

    public function resetPassword(User $user, string $code, string $password): bool
    {
        $record = $this->findValidRecord($user->email, $code);

        if (! $record) {
            return false;
        }

        $table = config('auth.passwords.users.table', 'password_resets');

        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();

        $user->tokens()->delete();

        DB::table($table)->where('email', $user->email)->delete();

        event(new PasswordReset($user));

        return true;
    }

    private function findValidRecord(string $email, string $code): ?object
    {
        $normalized = preg_replace('/\D/', '', $code) ?? '';

        if (strlen($normalized) !== 6) {
            return null;
        }

        $table = config('auth.passwords.users.table', 'password_resets');
        $record = DB::table($table)->where('email', $email)->first();

        if (! $record || ! $record->token || ! $record->created_at) {
            return null;
        }

        $expiresMinutes = (int) config('auth.passwords.users.expire', 60);
        $expiresAt = Carbon::parse($record->created_at)->addMinutes($expiresMinutes);

        if (Carbon::now()->greaterThan($expiresAt)) {
            return null;
        }

        if (! Hash::check($normalized, $record->token)) {
            return null;
        }

        return $record;
    }
}
