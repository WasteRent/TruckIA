<?php

namespace App\Console;

use App\Console\Commands\ImportCustomers;
use App\Console\Commands\ImportGarages;
use App\Console\Commands\SendWhatsapp;
use App\Console\Commands\SyncMaintenancePlanCounters;
use App\Jobs\EstinguisherAlertJob;
use App\Jobs\GenerateDailyCustomerPreventivesJob;
use App\Jobs\GenerateWeeklyCustomerPreventivesJob;
use App\Jobs\GetVehiclesTrackingJob;
use App\Jobs\GetVehiclesTripsJob;
use App\Jobs\ItvAlertJob;
use App\Jobs\MaintenanceAlertJob;
use App\Jobs\VehicleNaturalHoursJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        $schedule->job(new GetVehiclesTrackingJob)->everyFifteenMinutes();
        $schedule->job(new GetVehiclesTripsJob)->everyFifteenMinutes();
        $schedule->job(new ItvAlertJob)->dailyAt('06:00');
        $schedule->job(new MaintenanceAlertJob)->dailyAt('06:00');
        $schedule->job(new EstinguisherAlertJob)->dailyAt('06:00');

        $schedule->job(new VehicleNaturalHoursJob)->daily();

        $schedule->job(new GenerateDailyCustomerPreventivesJob)->dailyAt('08:00');
        $schedule->job(new GenerateWeeklyCustomerPreventivesJob)->thursdays()->at('08:00');

        Log::info('Sheduler ping');
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
