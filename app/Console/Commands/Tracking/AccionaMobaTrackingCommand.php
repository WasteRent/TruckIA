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
        $services = [
            412 => 'acciona_martorell',
            405 => 'acciona_premia_de_mar',
        ];

        foreach ($services as $location_id => $service) {
            $vehicles = Vehicle::whereIn('fleet_id', [30])->where('location_id', $location_id)->get();

            foreach ($vehicles as $vehicle) {
                try {
                    $data = $this->getData($service, $vehicle->plate);
                    $this->updateData($vehicle, $data);
                    $this->info($service . ' - ' . $vehicle->plate . ': ' . json_encode($data));

                } catch (\Throwable $e) {
                    $this->error($vehicle->plate . ' - ' . $e->getMessage());
                }

            }
        }
    }

    private function getData(string $service, string $plate)
    {
        $moba = new MobaClient(
            config('services.moba.'.$service.'.base_url'),
            config('services.moba.'.$service.'.username'),
            config('services.moba.'.$service.'.password'),
        );
        $maps = app(GeocodeClient::class);

        $data = $moba->getData(
            $plate,
            now()->subHours(1)->format('d/m/Y H:i:00'),
            now()->format('d/m/Y H:i:00')
        );
        $kms = $moba->getKms($plate, now()->subMonths(3)->format('d/m/Y H:i:00'), now()->format('d/m/Y H:i:00'));

        $xml = htmlspecialchars_decode($data);
        $dom = new \DOMDocument();
        $dom->loadXML($xml);

        $pos = $dom->getElementsByTagName('POSICION');
        $pos = $pos[count($pos) - 1];

        $lat = $pos->getElementsByTagName('POS_LATITUD')[0]->nodeValue;
        $lng = $pos->getElementsByTagName('POS_LONGITUD')[0]->nodeValue;

        $address = $maps->reverseGeocode($lat, $lng);

        return [
            'kms' => $kms,
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
            'kms' => $data['kms'],
            'engine_minutes' => 0,
            'fuel_level_percent' => 0,
            'address' => $data['address'],
            'latitude' => $data['lat'],
            'longitude' => $data['lng'],
            'fired_at' => date('Y-m-d H:i:s'),
        ]);

        $vehicle->incrementKms($data['kms'] - $vehicle->kms);
    }
}
