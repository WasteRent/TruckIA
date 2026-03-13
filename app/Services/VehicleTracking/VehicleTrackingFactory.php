<?php

namespace App\Services\VehicleTracking;

class VehicleTrackingFactory
{
    /**
     * @var array<string, VehicleTrackingServiceInterface>
     */
    private array $services;

    public function __construct(
        VehicleTrackingChip2chipService $chip2chip_service,
        VehicleTrackingMovisatService $movisat_service,
        VehicleTrackingDistromelService $distromel_service,
        VehicleTrackingWasteIdService $wasteid_service,
        VehicleTrackingMobaService $moba_service,
        VehicleTrackingWemobService $wemob_service
    ) {
        $this->services = [
            'chip2chip' => $chip2chip_service,
            'movisat' => $movisat_service,
            'distromel' => $distromel_service,
            'wasteid' => $wasteid_service,
            'moba' => $moba_service,
            'wemob' => $wemob_service,
        ];
    }

    public function getService(string $service_key) : VehicleTrackingServiceInterface
    {
        if (! isset($this->services[$service_key])) {
            throw new \InvalidArgumentException("Servicio {$service_key} no soportado");
        }

        return $this->services[$service_key];
    }

    public function getAvailableServices() : array
    {
        return array_keys($this->services);
    }
}

