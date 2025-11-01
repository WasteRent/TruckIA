<?php

namespace App\Listeners;

use App\Events\VehicleStateChanged;
use App\Models\VehicleState;
use App\Models\Vehicle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SendVehicleStateToLipasamSap implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VehicleStateChanged  $event
     * @return void
     */
    public function handle(VehicleStateChanged $event)
    {
        $this->sendSoapRequest($event->vehicle, $event->state);
    }

    private function sendSoapRequest(Vehicle $vehicle, VehicleState $state): void
    {
        $state = $state->id == VehicleState::AVAILABLE ? 'D' : 'N';

        $soapXml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <soap12:Envelope
          xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"
          xmlns:urn="urn:sap-com:document:sap:rfc:functions">
          <soap12:Header/>
          <soap12:Body>
            <urn:Z_PM_L_ESTADO_VEHICULO_MANUAL>
              <EQUNR>{$vehicle->plate}</EQUNR>
              <ESTADO>{$state}</ESTADO>
            </urn:Z_PM_L_ESTADO_VEHICULO_MANUAL>
          </soap12:Body>
        </soap12:Envelope>
        XML;

        $response = Http::withBasicAuth(
            config('services.lipasam_sap.username'),
            config('services.lipasam_sap.password')
        )
        ->withHeaders([
            'Content-Type' => 'application/soap+xml; charset=utf-8; action="urn:sap-com:document:sap:rfc:functions:Z_PM_L_ESTADO_VEHICULO_MANUAL:Z_PM_L_ESTADO_VEHICULO_MANUALRequest"'
        ])
        ->withBody($soapXml, 'application/soap+xml')
        ->post(config('services.lipasam_sap.endpoint'));

        if (!$response->successful()) {
            throw new \Exception("SOAP request failed with status {$response->status()}: {$response->body()}");
        }
    }

    public function shouldQueue(VehicleStateChanged $event)
    {
        $vehicle = $event->vehicle;

        $lipasam_customer_id = 241;
        return $vehicle->fleet_id == 1 && $vehicle->assigned_customer_id == $lipasam_customer_id;
    }
}

