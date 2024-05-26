<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class CustomVerifyEmail extends VerifyEmailNotification
{
    use Queueable;

    /**
     * Get the verification notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->line('Thank you for signing up with Smart Card Generator! We’re excited to have you on board. To complete your registration, please verify your email address by clicking the link below:')
            ->action('Verify Email Address', $url)
            ->line('Once you’ve verified your email, you’ll gain access to all the features and benefits of our platform. If you didn’t sign up for Smart Card Generator, please ignore this email.')
            ->line('Welcome to the Smart Card Generator community!')
            ->line('Best regards, ')
            ->line('Smart Card Generator');
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        $frontendUrl = config('app.frontend_url') . '/register-verify';

        $temporarySignedUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        return $frontendUrl . '?verification_url=' . urlencode($temporarySignedUrl);
    }
}
