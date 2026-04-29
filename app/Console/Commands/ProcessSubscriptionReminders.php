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

    protected $description = 'Mark expired subscriptions, queue renewal emails (2–5 days & urgent last days)';

    public function handle(): int
    {
        $tz = config('app.timezone');
        $now = Carbon::now($tz);
        $todayStart = $now->copy()->startOfDay();

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

        $queuedUpcoming = 0;
        $queuedUrgent = 0;

        foreach ($subscriptions as $subscription) {
            $user = $subscription->user;
            if (!$user || !$user->email) {
                continue;
            }

            $endDay = Carbon::parse($subscription->end_date)->timezone($tz)->startOfDay();
            $startToday = $todayStart->copy();

            if ($endDay->lt($startToday)) {
                continue;
            }

            $diffDays = (int) $startToday->diffInDays($endDay, false);

            if ($diffDays >= 2 && $diffDays <= 5) {
                Mail::to($user->email)->queue(
                    new SubscriptionReminderMail($subscription, 'upcoming')
                );
                $queuedUpcoming++;
                continue;
            }

            if ($diffDays === 0 || $diffDays === 1) {
                Mail::to($user->email)->queue(
                    new SubscriptionReminderMail($subscription, 'urgent')
                );
                $queuedUrgent++;
            }
        }

        $this->info("Queued upcoming reminders (2–5 days): {$queuedUpcoming}");
        $this->info("Queued urgent reminders (today / tomorrow): {$queuedUrgent}");

        return self::SUCCESS;
    }
}
