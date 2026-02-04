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
            618 => 'acciona_martorell', //UTE MARTORELL RSU y LV
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

        $lat = 0;
        $lng = 0;
        $address = "";
        $kms = 0;
        $hours = 0;

        try {
            $kms = $moba->getKms($plate, now()->subDays(10)->format('d/m/Y H:i:00'), now()->format('d/m/Y H:i:00'));
            $hours = $moba->getHours($plate, now()->subDays(10)->format('d/m/Y H:i:00'), now()->format('d/m/Y H:i:00'));
            $data = $moba->getData(
                $plate,
                now()->subHours(1)->format('d/m/Y H:i:00'),
                now()->format('d/m/Y H:i:00')
            );

            $xml = htmlspecialchars_decode($data);
            $dom = new \DOMDocument();
            $dom->loadXML($xml);

            $pos_nodes = $dom->getElementsByTagName('POSICION');
            $pos_count = $pos_nodes->length;

            if ($pos_count === 0) {
                $this->error($plate . '  sin nodos POSICION en la respuesta');
            }

            $pos = $pos_nodes->item($pos_count - 1);

            $lat_nodes = $pos->getElementsByTagName('POS_LATITUD');
            $lng_nodes = $pos->getElementsByTagName('POS_LONGITUD');

            if ($lat_nodes->length === 0 || $lng_nodes->length === 0) {
                $this->error($plate . ' sin nodos POS_LATITUD / POS_LONGITUD en la respuesta');
            }

            $lat = $lat_nodes->item(0)->nodeValue;
            $lng = $lng_nodes->item(0)->nodeValue;
            $address = $maps->reverseGeocode($lat, $lng);
        } catch (\Throwable|\Exception $e) {
            $this->error($e->getMessage());
        }

        return [
            'kms' => $kms['valor'] ?? 0,
            'hours' => $hours['valor'] ?? null,
            'fechaHora' => $kms['fechaHora'] ?? null,
            'lat' => $lat,
            'lng' => $lng,
            'address' => $address
        ];
    }

    private function updateData(Vehicle $vehicle, array $data)
    {
        $message_uid = md5($vehicle->id .'-'. $data['fechaHora']);

        $vehicle_tracking_exists = VehicleTracking::where('message_uid', $message_uid)->exists();

        if ($vehicle_tracking_exists) {
            $this->warn('tracking ya existente para vehículo ' . $vehicle->plate . ' no se actualiza');
            return;
        }

        VehicleTracking::create([
            'vehicle_id' => $vehicle->id,
            'message_uid' => $message_uid,
            'kms' => $data['kms'],
            'engine_minutes' => $data['hours'] * 60,
            'fuel_level_percent' => 0,
            'address' => $data['address'],
            'latitude' => $data['lat'] ,
            'longitude' => $data['lng'],
            'fired_at' => date('Y-m-d H:i:s'),
            'service' => 'acciona_moba'
        ]);

        $vehicle->incrementKms($data['kms'] - $vehicle->kms);
        $vehicle->incrementCanHours($data['hours'] - $vehicle->chassis_can_work_hours);
    }
}
