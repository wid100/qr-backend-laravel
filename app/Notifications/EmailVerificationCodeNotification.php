<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $code,
        public string $appLabel = 'Smart Card Generator'
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $minutes = (int) config('auth.verification.expire', 60);

        return (new MailMessage)
            ->subject("Your {$this->appLabel} verification code")
            ->view('emails.verification-code', [
                'code' => $this->code,
                'user' => $notifiable,
                'appLabel' => $this->appLabel,
                'expiresMinutes' => $minutes,
            ]);
    }
}
