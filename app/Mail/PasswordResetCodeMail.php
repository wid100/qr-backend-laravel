<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetCodeMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $code,
        public string $appLabel,
        public User $user
    ) {
    }

    public function build()
    {
        $minutes = (int) config('auth.passwords.users.expire', 60);

        return $this
            ->subject("Your {$this->appLabel} password reset code")
            ->view('emails.password-reset-code', [
                'code' => $this->code,
                'user' => $this->user,
                'appLabel' => $this->appLabel,
                'expiresMinutes' => $minutes,
            ]);
    }
}
