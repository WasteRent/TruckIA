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
        $services = ['accion_torrevieja', 'acciona_calpe', 'acciona_la_eliana'];

        foreach ($services as $service) {
            $client = new DistromelClient(
                config('services.distromel.acciona.base_url'),
                config('services.distromel.acciona.username'),
                config('services.distromel.acciona.password'),
                config('services.distromel.' . $service . '.key'),
            );

            $allowed_types = $client->getResourceTypes()->where('Family', 'MAQUINARIA')->pluck('ResourceTypeId')->toArray();

            foreach ($client->getResources() as $resource) {
                if (in_array($resource->ResourceTypeId, $allowed_types) && $v = $this->findVehicle($resource->Code)) {
                    $v->update(['webfleet_id' => $resource->ResourceId]);
                    $this->info("{$service}: $resource->Registration $resource->ResourceId");
                }
            }
        }

        

        return Command::SUCCESS;
    }

    private function findVehicle(string $code) {
        $code = preg_replace('/[^A-Za-z0-9]/', '', $code);
        return Vehicle::where(function($query) use ($code) {
            $query->where('internal_id', $code)->orWhere('plate', $code);
        })->where('fleet_id', 30)->first();
    }
}
