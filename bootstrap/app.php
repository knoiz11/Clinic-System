<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class, // register custom admin middleware
        ]);
    })

    // ✅ Register your custom console command
    ->withCommands([
        App\Console\Commands\AppointmentReminder::class,
    ])

    // ✅ Schedule the command to run every minute
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('reminder:appointments')->everyMinute();
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
