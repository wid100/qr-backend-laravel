<?php

namespace App\Notifications;

use App\Services\EmailVerificationCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function send($notifiable): void
    {
        app(EmailVerificationCodeService::class)->sendVerificationEmail(
            $notifiable,
            'Smart Card Generator'
        );
    }

    /** @deprecated Use send() via sendVerificationEmail on User model */
    public function toMail(object $notifiable)
    {
        $this->send($notifiable);
    }
}
