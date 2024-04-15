<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Qrgen;
use App\Models\Subscription;
use Carbon\Carbon;

class UpdateQRGenStatus extends Command
{
    protected $signature = 'qrgen:update-status';
    protected $description = 'Update the status of QRGen rows based on certain conditions';

    public function handle()
    {
        // Get all QRGen rows
        $qrgenRows = Qrgen::all();

        foreach ($qrgenRows as $row) {
            // Check if the user has a subscription
            $subscription = Subscription::where('user_id', $row->user_id)->first();

            // If the user has a subscription
            if ($subscription) {
                // Check if the subscription has expired
                if ($subscription->end_date < Carbon::now()) {
                    // Update status to 3
                    $row->status = 3;
                    $row->save();
                }
            } else {
                // If the user doesn't have a subscription, check if the QR was created more than 5 days ago
                if ($row->created_at->diffInDays(Carbon::now()) >= 1) {
                    // Update status to 4
                    $row->status = 0;
                    $row->save();
                }
            }
        }

        $this->info('QRGen row statuses updated successfully.');
    }
}
