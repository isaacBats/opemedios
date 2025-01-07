<?php

namespace App\Console;

use App\Console\Commands\SendNewsletter;
use App\Console\Commands\GenerateReport;
use App\Console\Commands\GenerateReportBig;
use App\Console\Commands\GenerateReportMedium;
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
        // SendNewsletter::class,
        GenerateReport::class,
        GenerateReportBig::class,
        GenerateReportMedium::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('newsletter:send')
        //     ->dailyAt('07:00');
        //          ->hourly();
        
        $schedule->command('report:generate')->everyFiveMinutes()->runInBackground();
        $schedule->command('report:generatemedium')->everyThirtyMinutes()->runInBackground();
        $schedule->command('report:generatebig')->hourly()->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // $this->load(__DIR__.'/Commands');

        // require base_path('routes/console.php');
    }
}
