<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * Return the most recent subscription row for a user.
     */
    public function latestForUser(int $userId): ?Subscription
    {
        return Subscription::where('user_id', $userId)->latest('id')->first();
    }

    /**
     * A subscription is active when:
     *  - the row exists
     *  - status === 'active'
     *  - end_date is in the future (or right now)
     */
    public function isActive(?Subscription $subscription): bool
    {
        if (!$subscription) {
            return false;
        }

        return $subscription->status === 'active'
            && Carbon::parse($subscription->end_date)->gte(Carbon::now());
    }

    /**
     * Build the subscription status string ('none' | 'active' | 'expired').
     */
    public function statusString(?Subscription $subscription): string
    {
        if (!$subscription) {
            return 'none';
        }

        return $this->isActive($subscription) ? 'active' : 'expired';
    }

    /**
     * Return an array ready to merge into the /api/user response.
     */
    public function payloadForUser(User $user): array
    {
        $sub = $this->latestForUser($user->id);

        return [
            'subscribed'          => $this->isActive($sub),
            'subscription_status' => $this->statusString($sub),
            'subscription_ends_at' => $sub ? Carbon::parse($sub->end_date)->toDateTimeString() : null,
        ];
    }

    /**
     * Create or update (renew) the subscription row for a user.
     *
     * One row per user: if a row already exists it is updated so that
     * payment history stays in the payments table while subscription truth
     * lives in a single mutable row.
     *
     * Returns ['subscription' => Subscription, 'renewed' => bool].
     */
    public function createOrRenew(
        int    $userId,
        int    $packageId,
        int    $paymentId,
        Carbon $startDate,
        Carbon $endDate,
        string $status = 'active'
    ): array {
        $existing = Subscription::where('user_id', $userId)->latest('id')->first();

        if ($existing) {
            $existing->update([
                'package_id' => $packageId,
                'payment_id' => $paymentId,
                'start_date' => $startDate,
                'end_date'   => $endDate,
                'status'     => $status,
            ]);

            return ['subscription' => $existing->fresh(), 'renewed' => true];
        }

        $subscription = Subscription::create([
            'user_id'    => $userId,
            'package_id' => $packageId,
            'payment_id' => $paymentId,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'status'     => $status,
        ]);

        return ['subscription' => $subscription, 'renewed' => false];
    }
}
