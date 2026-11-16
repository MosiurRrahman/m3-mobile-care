<?php

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Automated Cron Task:
 * Alert assigned technicians via SMS 1 day before the expected delivery date to get the phone ready.
 * Runs hourly between 09:00 AM and 09:00 PM (Asia/Dhaka) during shop working hours.
 */
Schedule::command('repairs:send-technician-reminders')
    ->hourly()
    ->between('09:00', '21:00')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/technician-reminders.log'));

