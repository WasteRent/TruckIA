<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Illuminate\Console\Command;

class CalculateMaintenanceScoreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-maintenance-score';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates and updates the maintenance score for all vehicles.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Calculating maintenance scores for vehicles...');

        foreach (Vehicle::cursor() as $vehicle) {
            $maintenanceScore = $vehicle->counters->where('completedPercent', '>=', 70)->count();
            $vehicle->update(['maintenance_score' => $maintenanceScore]);
            $this->info("Vehicle {$vehicle->plate}: {$maintenanceScore}");
        }

        $this->info('Maintenance score calculation complete.');
    }
}
