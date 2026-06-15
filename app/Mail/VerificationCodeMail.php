<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
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
        $minutes = (int) config('auth.verification.expire', 60);

        return $this
            ->subject("Your {$this->appLabel} verification code")
            ->view('emails.verification-code', [
                'code' => $this->code,
                'user' => $this->user,
                'appLabel' => $this->appLabel,
                'expiresMinutes' => $minutes,
            ]);
    }
}
