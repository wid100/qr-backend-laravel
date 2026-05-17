<?php

namespace App\Mail;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Queued renewal reminders at fixed milestones before end_date.
 */
class SubscriptionReminderMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Subscription $subscription,
        public int $daysRemaining
    ) {
    }

    public function build()
    {
        $appName = config('app.name');
        $days = $this->daysRemaining;

        if ($days <= 1) {
            $subject = "{$appName}: Your subscription expires "
                . ($days === 0 ? 'today' : 'tomorrow')
                . ' — please renew';
        } elseif ($days <= 7) {
            $subject = "{$appName}: Subscription expires in {$days} days — please renew";
        } elseif ($days === 30) {
            $subject = "{$appName}: Subscription expires in 1 month — renewal reminder";
        } else {
            $subject = "{$appName}: Subscription expires in {$days} days — renewal reminder";
        }

        return $this->subject($subject)
            ->view('emails.subscription-reminder');
    }
}
