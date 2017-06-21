<?php

namespace App\Console;

use App\Console\Commands\FetchEquity;
use App\Console\Commands\ProcessEquity;
use App\Console\Commands\SendAlerts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        FetchEquity::class,
        ProcessEquity::class,
        SendAlerts::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('fetch')->dailyAt('2:00');
        $schedule->command('process')->dailyAt('2:20');
        $schedule->command('alert')->dailyAt('2:40');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
