<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class FleetExportController extends Controller
{
    public function vehicles(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID interno', 'Cliente', 'Matricula', 'Marca', 'Modelo', 'Tipo', 'Equipos', 'VIN', 'Fecha Matriculación', 'Fecha Compra', 'Fecha ITV', 'Fecha Baja', 'Fecha Garantía', 'Kms', 'Horas GPS', 'Horas Motor', 'Ancho (M)', 'Alto (M)', 'Largo (M)', 'Tara (kg)', 'Combustible', 'Euro', 'Webfleet ID', 'Tacógrafo'], ';');

            foreach (Vehicle::filter($request->toArray())->where('fleet_id', Auth::user()->fleet->id)->get() as $vehicle) {
                $i = 1;
                $equipments = '';
                foreach ($vehicle->equipments as $equipment) {
                    $equipments .= "Equipo {$i}: Tipo {$i} {$equipment->type} Marca {$i} {$equipment->maker?->name} Modelo {$i} {$equipment->model?->name}. ";
                    $i++;
                }
                fputcsv($file, [
                    $vehicle->internal_id,
                    $vehicle->customer->email,
                    $vehicle->plate,
                    $vehicle->chassisMaker?->name,
                    $vehicle->chassisModel?->name,
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
                    $vehicle->tachograph,
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
            fputcsv($file, ['Nombre', 'CIF', 'Dirección', 'Localidad', 'Provincia', 'CP', 'M.O.']);

            foreach (Garage::where('fleet_id', Auth::user()->fleet->id)->get() as $garage) {
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
            fputcsv($file, ['Grupo', 'Nombre', 'CIF', 'Dirección', 'Localidad', 'Provincia', 'CP', 'Contacto 1', 'Email 1', 'Tel. 1', 'Contacto 2', 'Email 2', 'Tel. 2', 'Contacto 3', 'Email 3', 'Tel. 3', 'Contacto 4', 'Email 4', 'Tel. 4'], ';');

            foreach (Customer::where('fleet_id', Auth::user()->fleet->id)->get() as $customer) {
                fputcsv($file, ['', $customer->name, $customer->cif, $customer->address, $customer->state, $customer->province, $customer->zip, $customer->contact1, $customer->email1, $customer->phone1, $customer->contact2, $customer->email2, $customer->phone2, $customer->contact3, $customer->email3, $customer->phone3, $customer->contact4, $customer->email4, $customer->phone4], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'clientes.csv', $this->getHeaders());
    }

    public function orders(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Fecha apertura', 'Matricula', 'Chasis', 'Equipo', 'Taller', 'Estado', 'Notas'], ';');

            foreach (RepairOrder::filter($request->toArray())->where('fleet_id', Auth::user()->fleet->id)->get() as $order) {
                fputcsv($file, [$order->id, $order->created_at, $order->vehicle->plate, $order->vehicle->chassis, $order->vehicle->equipment, $order->garage->name, $order->state->name, strip_tags($order->internal_notes)], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'ordenes.csv', $this->getHeaders());
    }


    public function itv(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Matricula', 'Fecha ITV', 'Caducada'], ';');
            foreach (Vehicle::filter($request->toArray())->where('fleet_id', Auth::user()->fleet->id)->whereNotNull('itv_date')->get() as $vehicle) {
                fputcsv($file, [
                    $vehicle->plate,
                    Carbon::parse($vehicle->itv_date)->format('d/m/Y'),
                    Carbon::parse($vehicle->itv_date)->isPast() ? 'Si':'No',
                ], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'itv.csv', $this->getHeaders());
    }

    public function tacograph(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Matricula', 'Fecha Tacógrafo', 'Caducado'], ';');

            foreach (Vehicle::filter($request->toArray())->where('fleet_id', Auth::user()->fleet->id)->whereNotNull('tachograph_date')->get() as $vehicle) {
                fputcsv($file, [
                    $vehicle->plate,
                    Carbon::parse($vehicle->tachograph_date)->format('d/m/Y'),
                    Carbon::parse($vehicle->tachograph_date)->isPast() ? 'Si':'No',
                ], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'tacografos.csv', $this->getHeaders());
    }

    public function extinguisher(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Matricula', 'Código', 'Nombre', 'Fecha', 'Caducado'], ';');

            foreach (Vehicle::filter($request->toArray())->where('fleet_id', Auth::user()->fleet->id)->get() as $vehicle) {
                foreach ($vehicle->estinguishers as $extinguisher) {
                    fputcsv($file, [
                        $vehicle->plate,
                        $extinguisher->code,
                        $extinguisher->name,
                        Carbon::parse($extinguisher->expiration_date)->format('d/m/Y'),
                        Carbon::parse($extinguisher->expiration_date)->isPast() ? 'Si':'No',
                    ], ';');
                }

            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'extintores.csv', $this->getHeaders());
    }

    private function getHeaders()
    {
        return [
            'Content-type' => 'text/csv, charset=UTF-8',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    }
}
