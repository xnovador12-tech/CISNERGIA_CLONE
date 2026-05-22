<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('emails:enviar-programados')
    ->everyFiveMinutes()
    ->withoutOverlapping(10)
    ->runInBackground()
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::warning('Scheduler: fallo al ejecutar emails:enviar-programados');
    });

Schedule::command('queue:work --stop-when-empty --max-time=290 --tries=3 --sleep=2')
    ->everyMinute()
    ->withoutOverlapping(5)
    ->runInBackground()
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::warning('Scheduler: fallo al ejecutar queue:work');
    });
