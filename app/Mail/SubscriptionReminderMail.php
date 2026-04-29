<?php

namespace App\Mail;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Queued renewal reminders (5-day window vs last-day / expiry-day).
 */
class SubscriptionReminderMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Subscription $subscription,
        public string $variant
    ) {
    }

    public function build()
    {
        $subject = $this->variant === 'urgent'
            ? config('app.name') . ': Your Smart Visiting Card subscription expires soon — please renew'
            : config('app.name') . ': Reminder — Smart Visiting Card subscription ending within a few days';

        return $this->subject($subject)
            ->view('emails.subscription-reminder');
    }
}
