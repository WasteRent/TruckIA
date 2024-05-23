<?php

namespace App\Console\Commands\Tracking;

use App\Classes\Distromel\DistromelClient;
use App\Models\Vehicle;
use Illuminate\Console\Command;

class LinkDistromelVehiclesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distromel:link-vehicles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new DistromelClient(
            config('services.distromel.acciona.base_url'),
            config('services.distromel.acciona.username'),
            config('services.distromel.acciona.password'),
            config('services.distromel.acciona.key'),
        );

        $allowed_types = $client->getResourceTypes()->where('Family', 'MAQUINARIA')->pluck('ResourceTypeId')->toArray();
        foreach ($client->getResources() as $resource) {
            if (in_array($resource->ResourceTypeId, $allowed_types) && Vehicle::where('internal_id', $resource->Code)->where('fleet_id', 30)->exists()) {
                Vehicle::where('internal_id', $resource->Code)->where('fleet_id', 30)->update([
                    'webfleet_id' => $resource->ResourceId,
                ]);
                $this->info("$resource->Registration $resource->ResourceId");
            }
        }

        return Command::SUCCESS;
    }
}
