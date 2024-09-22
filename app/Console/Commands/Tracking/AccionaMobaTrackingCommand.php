<?php

namespace App\Console\Commands\Tracking;

use App\Classes\GoogleMaps\GeocodeClient;
use App\Classes\Moba\MobaClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Illuminate\Console\Command;

class AccionaMobaTrackingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:acciona-moba';

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
        $vehicles = Vehicle::whereIn('fleet_id', [30])->where('location_id', 405)->get();

        foreach ($vehicles as $vehicle) {
            try {
                $data = $this->getData($vehicle->plate);
                $this->updateData($vehicle, $data);
            } catch (\Throwable $e) {
                echo $e->getMessage()."\n";
            }

            $this->info($vehicle->plate);
        }
    }

    private function getData(string $plate)
    {
        $moba = new MobaClient(
            config('services.moba.acciona.base_url'),
            config('services.moba.acciona.username'),
            config('services.moba.acciona.password'),
        );
        $maps = app(GeocodeClient::class);

        $data = $moba->getData(
            $plate,
            now()->subHours(1)->format('d/m/Y H:i:00'),
            now()->format('d/m/Y H:i:00')
        );

        $xml = htmlspecialchars_decode($data);
        $dom = new \DOMDocument();
        $dom->loadXML($xml);

        $pos = $dom->getElementsByTagName('POSICION');
        $pos = $pos[count($pos) - 1];

        $lat = $pos->getElementsByTagName('POS_LATITUD')[0]->nodeValue;
        $lng = $pos->getElementsByTagName('POS_LONGITUD')[0]->nodeValue;

        $address = $maps->reverseGeocode($lat, $lng);

        return [
            'kms' => (int) $dom->getElementsByTagName('KM')[0]->childNodes[0]->nodeValue,
            'lat' => $lat,
            'lng' => $lng,
            'address' => $address,
        ];
    }

    private function updateData(Vehicle $vehicle, array $data)
    {
        VehicleTracking::create([
            'vehicle_id' => $vehicle->id,
            'message_uid' => md5(time()),
            'kms' => $vehicle->kms + $data['kms'],
            'engine_minutes' => 0,
            'fuel_level_percent' => 0,
            'address' => $data['address'],
            'latitude' => $data['lat'],
            'longitude' => $data['lng'],
            'fired_at' => date('Y-m-d H:i:s'),
        ]);

        $vehicle->incrementKms($data['kms']);
    }
}
