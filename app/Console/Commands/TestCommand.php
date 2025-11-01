<?php

namespace App\Console\Commands;

use App\Classes\Distromel\DistromelClient;
use App\Classes\Moba\MobaClient;
use App\Classes\WeMob\WeMobClient;
use App\Imports\UsersImport;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use App\Models\VehicleState;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Http;


class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

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
        $response = Http::withBasicAuth('RFCLIP_WAS', 'ZIUT_#_3456_@12')
        ->withHeaders([
            'Content-Type' => 'application/soap+xml; charset=utf-8; action="urn:sap-com:document:sap:rfc:functions:Z_PM_L_ESTADO_VEHICULO_MANUAL:Z_PM_L_ESTADO_VEHICULO_MANUALRequest"',a
        ])->withBody(
            <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <soap12:Envelope
          xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"
          xmlns:urn="urn:sap-com:document:sap:rfc:functions">
          <soap12:Header/>
          <soap12:Body>
            <urn:Z_PM_L_ESTADO_VEHICULO_MANUAL>
              <EQUNR>000000100100000001</EQUNR>
              <ESTADO>A</ESTADO>
            </urn:Z_PM_L_ESTADO_VEHICULO_MANUAL>
          </soap12:Body>
        </soap12:Envelope>
        XML,
            'application/soap+xml'
        )->post('https://prewss.lipasam.es/z_pm_l_estado_vehiculo_manual');

        // Mostrar resultado
        if ($response->successful()) {
            echo "✅ Respuesta del servicio:\n";
            echo htmlspecialchars($response->body());
        } else {
            echo "❌ Error ({$response->status()}): " . $response->body();
        }
    }
}
