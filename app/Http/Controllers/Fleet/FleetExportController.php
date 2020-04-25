<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

class FleetExportController extends Controller
{

    public function vehicles()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ["Matricula;Marca;Modelo;VIN;Fecha Matriculación;Fecha Compra;Fecha ITV;Fecha Baja;Kms;Horas Trabajo;Horas CAN;Combustible;Euro"]);

            foreach (Vehicle::whereNull('discharged_date')->get() as $vehicle) {
                fputcsv($file, [$vehicle->plate, $vehicle->chassisMaker->name, $vehicle->chassisModel->name, $vehicle->vin, $vehicle->registration_date, $vehicle->purchase_date, $vehicle->itv_date, $vehicle->discharged_date, $vehicle->kms, $vehicle->work_hours, $vehicle->can_hours, $vehicle->fuel, $vehicle->euro], ';');
            }
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'vehicles.csv', $this->getHeaders());
    }

    private function getHeaders()
    {
        return [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
    }
}
