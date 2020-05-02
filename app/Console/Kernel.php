<?php

namespace App\Console;

use App\Console\Commands\AddSubjectTypes;
use App\Console\Commands\CreateRoles;
use App\Console\Commands\CreateWeeks;
use App\Console\Commands\SetDefaultTime;
use App\Console\Commands\Upload;
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
        Commands\CheckSchedule::class,
        Commands\CreateAdmin::class,
        CreateRoles::class,
        SetDefaultTime::class,
        AddSubjectTypes::class,
        Upload::class,
        CreateWeeks::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
