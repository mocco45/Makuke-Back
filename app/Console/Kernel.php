<?php

namespace App\Console;

use App\Console\Commands\CalculateDueDates;
use App\Console\Commands\DueDates;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        DueDates::class
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:due-dates')->everyFiveSeconds();
        $schedule->command('close:balance')->dailyAt('20:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
