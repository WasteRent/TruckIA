<?php

namespace App\Jobs;

use App\Classes\GoogleMaps\GeocodeClient;
use App\Classes\Moba\MobaClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetVehiclesTrackingMobaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $vehicles = Vehicle::where('fleet_id', 7)->get();

        foreach ($vehicles as $vehicle) {
            $data = $this->getData($vehicle->plate);

            $this->updateData($vehicle, $data);

            echo "$vehicle->plate \n";
        }
    }

    private function getData(string $plate) {
        $moba = app(MobaClient::class);
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
            'kms' => (int)$dom->getElementsByTagName('KM')[0]->childNodes[0]->nodeValue,
            'lat' => $lat,
            'lng' => $lng,
            'address' => $address
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

        $vehicle->incrementKms($data['kms']);
    }
}
