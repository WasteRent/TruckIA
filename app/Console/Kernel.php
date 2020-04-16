<?php

namespace App\Console;

use App\Console\Commands\ImportCustomers;
use App\Console\Commands\ImportGarages;
use App\Console\Commands\SendWhatsapp;
use App\Console\Commands\SyncMaintenancePlanCounters;
use App\Jobs\GetVehiclesTrackingJob;
use App\Jobs\GetVehiclesTripsJob;
use App\Jobs\ItvAlertJob;
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
        ImportGarages::class,
        ImportCustomers::class,
        SendWhatsapp::class,
        SyncMaintenancePlanCounters::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new GetVehiclesTrackingJob)->everyThirtyMinutes();
        $schedule->job(new GetVehiclesTripsJob)->everyThirtyMinutes();
        $schedule->job(new ItvAlertJob)->dailyAt('06:00');
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
