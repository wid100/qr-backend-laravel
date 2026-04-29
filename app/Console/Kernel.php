<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->command('qrgen:update-status')->daily();
    // }



    protected function schedule(Schedule $schedule)
    {
        $schedule->command('qrgen:update-status')->everyMinute();

        // Daily at midnight (app timezone: config app.timezone / APP_TIMEZONE). Expire subs + queue renewal emails.
        $schedule->command('subscriptions:process-reminders')
            ->dailyAt('00:00')
            ->timezone(config('app.timezone'));
    }



    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
