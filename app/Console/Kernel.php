<?php

namespace App\Console;

use App\Jobs\EstinguisherAlertJob;
use App\Jobs\GenerateDailyCustomerPreventivesJob;
use App\Jobs\GenerateWeeklyCustomerPreventivesJob;
use App\Jobs\ItvAlertJob;
use App\Jobs\MaintenanceAlertJob;
use App\Jobs\TachographAlertJob;
use App\Jobs\VehicleInGarageAlertJob;
use App\Jobs\VehicleNaturalHoursJob;
use App\Jobs\WarrantyAlertJob;
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

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Tracking
        $schedule->command('tracking:wasterent-webfleet')->everyFifteenMinutes();
        $schedule->command('tracking:tetma-moba')->everyFifteenMinutes();
        $schedule->command('tracking:acciona-distromel')->everyFifteenMinutes();
        $schedule->command('tracking:acciona-wemob')->everyFifteenMinutes();
        $schedule->command('tracking:acciona-moba')->hourly();
        $schedule->command('tracking:acciona-chip2chip')->hourly();
        $schedule->command('tracking:acciona-movisat')->hourly();

        //$schedule->command('tracking:svat-wemob')->everyFifteenMinutes();
        $schedule->command('tracking:svat-movisat')->everyFifteenMinutes();

        $schedule->command('distromel:link-vehicles')->daily();

        $schedule->job(new ItvAlertJob)->dailyAt('06:00');
        $schedule->job(new MaintenanceAlertJob)->dailyAt('06:00');
        $schedule->job(new EstinguisherAlertJob)->dailyAt('06:00');
        $schedule->job(new TachographAlertJob)->dailyAt('06:00');
        $schedule->job(new WarrantyAlertJob)->dailyAt('06:00');

        $schedule->job(new VehicleNaturalHoursJob)->daily();
        $schedule->job(new VehicleInGarageAlertJob)->daily();

        $schedule->job(new GenerateDailyCustomerPreventivesJob)->dailyAt('08:00');
        $schedule->job(new GenerateWeeklyCustomerPreventivesJob)->thursdays()->at('08:00');

        $schedule->command('maintenance:sync')->everyFifteenMinutes();
        $schedule->command('app:calculate-maintenance-score')->everyFifteenMinutes();
        $schedule->command('vehicles:import-from-odoo')->dailyAt('06:00');
        $schedule->command('vehicles:send-state-to-odoo')->cron('10,40 * * * *');
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
