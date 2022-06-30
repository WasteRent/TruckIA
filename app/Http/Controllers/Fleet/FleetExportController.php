<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Garage;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FleetExportController extends Controller
{

    public function vehicles(Request $request)
    {
        
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ["Matricula","Marca","Modelo","Tipo","Equipos","VIN","Fecha Matriculación","Fecha Compra","Fecha ITV","Fecha Baja","Fecha Garantía","Kms","Horas GPS","Horas Motor","Ancho (M)","Alto (M)","Largo (M)","Tara (kg)","Combustible","Euro","Webfleet ID","Tacógrafo"], ';');

            foreach (Vehicle::filter($request->toArray())->where('fleet_id', Auth::user()->fleet->id)->get() as $vehicle) {
                $i=1;
                $equipments='';
                foreach ($vehicle->equipments as $equipment) {
                    $equipments .= "Equipo {$i}: Tipo {$i} {$equipment->type} Marca {$i} {$equipment->maker->name} Modelo {$i} {$equipment->model->name}. ";
                    $i++;
                }
                fputcsv($file, [
                    $vehicle->plate,
                    $vehicle->chassisMaker->name,
                    $vehicle->chassisModel->name,
                    optional($vehicle->type)->name,
                    $equipments,
                    $vehicle->vin,
                    $vehicle->registration_date,
                    $vehicle->purchase_date,
                    $vehicle->itv_date,
                    $vehicle->discharged_date,
                    $vehicle->warranty_date,
                    $vehicle->kms,
                    $vehicle->chassis_gps_work_hours,
                    $vehicle->chassis_can_work_hours,
                    $vehicle->width,
                    $vehicle->height,
                    $vehicle->length,
                    $vehicle->tare_kg,
                    $vehicle->fuel,
                    $vehicle->euro,
                    $vehicle->webfleet_id,
                    $vehicle->tachograph
                ], ';');
            }
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'vehicles.csv', $this->getHeaders());
    }

    public function garages()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ["Nombre","CIF","Dirección","Localidad","Provincia","CP","M.O."]);

            foreach (Garage::all() as $garage) {
                fputcsv($file, [$garage->name, $garage->cif, $garage->address, $garage->state, $garage->province, $garage->zip, $garage->hourly_price], ';');
            }
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'talleres.csv', $this->getHeaders());
    }

    public function customers()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ["Grupo","Nombre","CIF","Dirección","Localidad","Provincia","CP","Contacto 1","Email 1","Tel. 1","Contacto 2","Email 2","Tel. 2","Contacto 3","Email 3","Tel. 3","Contacto 4","Email 4","Tel. 4"], ";");

            foreach (Customer::all() as $customer) {
                fputcsv($file, ['', $customer->name, $customer->cif, $customer->address, $customer->state, $customer->province, $customer->zip, $customer->contact1, $customer->email1, $customer->phone1, $customer->contact2, $customer->email2, $customer->phone2, $customer->contact3, $customer->email3, $customer->phone3, $customer->contact4, $customer->email4, $customer->phone4], ';');
            }
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'clientes.csv', $this->getHeaders());
    }

    private function getHeaders()
    {
        return [
            "Content-type" => "text/csv, charset=UTF-8",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
    }
}
