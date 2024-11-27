<?php

namespace App\Http\Controllers\Fleet;

use App\Exports\MechanicsExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\VehiclesExport;
use Maatwebsite\Excel\Facades\Excel;

class FleetExportController extends Controller
{
    public function vehicles(Request $request)
    {
        return Excel::download(new VehiclesExport($request), 'vehicles.xlsx');
    }

    public function mechanics(Request $request)
    {
        return Excel::download(new MechanicsExport($request), 'mechanics.xlsx');
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

            $customers = Customer::whereHas('vehicles', function ($q) {
                $q->allowForUser();
            })->get();

            foreach ($customers as $customer) {
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

            $orders = RepairOrder::filter($request->toArray())->allowForUser()->get();
            foreach ($orders as $order) {
                fputcsv($file, [$order->id, $order->created_at, $order->vehicle->plate, $order->vehicle->chassis, $order->vehicle->equipment, $order->garage?->name, $order->state?->name, strip_tags($order->internal_notes)], ';');
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

            $vehicles = Vehicle::filter($request->toArray())->allowForUser()->whereNotNull('itv_date')->get();
            foreach ($vehicles as $vehicle) {
                fputcsv($file, [
                    $vehicle->plate,
                    Carbon::parse($vehicle->itv_date)->format('d/m/Y'),
                    Carbon::parse($vehicle->itv_date)->isPast() ? 'Si' : 'No',
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

            $vehicles = Vehicle::filter($request->toArray())->allowForUser()->whereNotNull('tachograph_date')->get();
            foreach ($vehicles as $vehicle) {
                fputcsv($file, [
                    $vehicle->plate,
                    Carbon::parse($vehicle->tachograph_date)->format('d/m/Y'),
                    Carbon::parse($vehicle->tachograph_date)->isPast() ? 'Si' : 'No',
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

            $vehicles = Vehicle::filter($request->toArray())->allowForUser()->get();
            foreach ($vehicles as $vehicle) {
                foreach ($vehicle->estinguishers as $extinguisher) {
                    fputcsv($file, [
                        $vehicle->plate,
                        $extinguisher->code,
                        $extinguisher->name,
                        Carbon::parse($extinguisher->expiration_date)->format('d/m/Y'),
                        Carbon::parse($extinguisher->expiration_date)->isPast() ? 'Si' : 'No',
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
