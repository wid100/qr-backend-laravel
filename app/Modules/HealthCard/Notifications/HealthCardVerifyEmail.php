<?php

namespace App\Modules\HealthCard\Notifications;

use App\Notifications\EmailVerificationCodeNotification;
use App\Services\EmailVerificationCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class HealthCardVerifyEmail extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable)
    {
        $code = app(EmailVerificationCodeService::class)->issueCode($notifiable);

        return (new EmailVerificationCodeNotification($code, 'Smart Health Card'))
            ->toMail($notifiable);
    }
}
