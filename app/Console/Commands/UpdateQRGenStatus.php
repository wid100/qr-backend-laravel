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
        $qrgenRows = Qrgen::all();

        foreach ($qrgenRows as $row) {
            $subscription = Subscription::where('user_id', $row->user_id)->first();

            if ($subscription) {
                if ($subscription->end_date < Carbon::now()) {
                    $row->status = 'paused';
                    $row->save();
                } else {
                    $row->status = 'active';
                    $row->save();
                }
            } else {
                if ($row->created_at->diffInDays(Carbon::now()) >= 5) {
                    $row->status = 'expired';
                    $row->save();
                }
            }
        }

        $this->info('QRGen row statuses updated successfully.');
    }
}
