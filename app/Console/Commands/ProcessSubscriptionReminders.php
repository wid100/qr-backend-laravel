<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionReminderMail;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessSubscriptionReminders extends Command
{
    protected $signature = 'subscriptions:process-reminders';

    protected $description = 'Mark expired subscriptions and send renewal emails (30, 15, 7, 3, 1 days before expiry)';

    public function handle(): int
    {
        $tz = config('app.timezone');
        $now = Carbon::now($tz);
        $todayStart = $now->copy()->startOfDay();

        $reminderDays = array_map('intval', config('subscription.reminder_days', [30, 15, 7, 3, 1]));
        sort($reminderDays);

        $expiredCount = Subscription::query()
            ->where('status', 'active')
            ->where('end_date', '<', $now)
            ->update(['status' => 'expired']);

        $this->info("Marked {$expiredCount} subscription(s) as expired.");

        $latestIds = Subscription::query()
            ->selectRaw('MAX(id) as id')
            ->groupBy('user_id')
            ->pluck('id');

        $subscriptions = Subscription::query()
            ->with(['user', 'package'])
            ->where('status', 'active')
            ->whereIn('id', $latestIds)
            ->get();

        $queuedByDay = array_fill_keys($reminderDays, 0);

        foreach ($subscriptions as $subscription) {
            $user = $subscription->user;
            if (! $user || ! $user->email) {
                continue;
            }

            $endDay = Carbon::parse($subscription->end_date)->timezone($tz)->startOfDay();

            if ($endDay->lt($todayStart)) {
                continue;
            }

            $daysRemaining = (int) $todayStart->diffInDays($endDay);

            if (! in_array($daysRemaining, $reminderDays, true)) {
                continue;
            }

            Mail::to($user->email)->queue(
                new SubscriptionReminderMail($subscription, $daysRemaining)
            );

            $queuedByDay[$daysRemaining]++;
        }

        foreach ($reminderDays as $days) {
            $label = $days === 30 ? '30 days (1 month)' : "{$days} day(s)";
            $this->info("Queued reminders ({$label} before expiry): {$queuedByDay[$days]}");
        }

        return self::SUCCESS;
    }
}
