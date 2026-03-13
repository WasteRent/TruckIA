<?php

namespace App\Services\VehicleTracking;

interface VehicleTrackingServiceInterface
{
    /**
     * Obtiene los datos de tracking para una matrícula concreta.
     *
     * Debe devolver un array de filas con una estructura uniforme:
     * [
     *     [
     *         'service' => string,
     *         'plate' => string,
     *         'kms' => float|null,
     *         'engine_hours' => float|null,
     *         'meta' => array, // ids externos, etc.
     *         'raw' => mixed,  // respuesta original del proveedor (opcional)
     *     ],
     * ]
     */
    public function getDataByPlate(string $plate) : array;

    /**
     * Obtiene los datos de tracking para un servicio concreto.
     *
     * Ejemplo de $filters soportados (pueden ampliarse):
     * - plate
     * - kms_from, kms_to
     * - hours_from, hours_to
     */
    public function getDataForService(string $service_key, array $filters = []) : array;

    /**
     * Devuelve las claves de servicio disponibles para este proveedor.
     *
     * Ejemplos:
     * - Chip2Chip: acciona_chip2chip_alcobendas, acciona_chip2chip_calpe, ...
     * - Movisat: acciona_coslada, acciona_colmenar_viejo, ...
     * - Distromel: acciona_calpe, ...
     */
    public function getAvailableServiceKeys() : array;
}

