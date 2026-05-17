<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Expiry reminder schedule (days before end_date)
    |--------------------------------------------------------------------------
    |
    | The daily `subscriptions:process-reminders` command sends one email
    | per milestone when the subscription end date is exactly N days away.
    |
    */
    'reminder_days' => [30, 15, 7, 3, 1],

];
