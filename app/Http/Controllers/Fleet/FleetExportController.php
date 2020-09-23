<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Garage;
use App\Models\Vehicle;

class FleetExportController extends Controller
{

    public function vehicles()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ["Matricula;Marca;Modelo;Tipo;VIN;Fecha Matriculación;Fecha Compra;Fecha ITV;Fecha Baja;Kms;Horas GPS;Horas Motor;Combustible;Euro"]);

            foreach (Vehicle::whereNull('discharged_date')->get() as $vehicle) {
                fputcsv($file, [$vehicle->plate, $vehicle->chassisMaker->name, $vehicle->chassisModel->name, optional($vehicle->type)->name, $vehicle->vin, $vehicle->registration_date, $vehicle->purchase_date, $vehicle->itv_date, $vehicle->discharged_date, $vehicle->kms, $vehicle->chassis_gps_work_hours, $vehicle->chassis_can_work_hours, $vehicle->fuel, $vehicle->euro], ';');
            }
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'vehicles.csv', $this->getHeaders());
    }

    public function garages()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ["Nombre","Dirección","Localidad","Provincia","CP","M.O."]);

            foreach (Garage::all() as $garage) {
                fputcsv($file, [$garage->name, $garage->address, $garage->state, $garage->province, $garage->zip, $garage->hourly_price], ';');
            }
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'talleres.csv', $this->getHeaders());
    }

    public function customers()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ["Grupo","Nombre","Dirección","Localidad","Provincia","CP"]);

            foreach (Customer::all() as $customer) {
                fputcsv($file, ['', $customer->name, $customer->address, $customer->state, $customer->province, $customer->zip], ';');
            }
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'clientes.csv', $this->getHeaders());
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
