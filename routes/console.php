<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();

Schedule::command('check:refund-of-listing-due-to-end-date_schedule')->everyMinute();
Schedule::command('check:lister-payment-timeout_schedule')->everyMinute();
Schedule::command('check-incoming-lister-payment_schedule')->everyMinute();
Schedule::command('check-incoming-buyer-payment_schedule')->everyMinute();
