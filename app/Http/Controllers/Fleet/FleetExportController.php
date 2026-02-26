<?php

namespace App\Http\Controllers\Fleet;

use App\Exports\MechanicsExport;
use App\Exports\VehiclesArchivesExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\VehiclesExport;
use App\Exports\VehicleWashingExport;
use App\Models\AdditionalVehicleExpense;
use App\Models\Container;
use App\Models\EnterpriseGroup;
use App\Models\SparePart;
use App\Models\VehicleGuarantee;
use App\Models\VehicleIncident;
use App\Services\RepairOrderExportService;
use App\User;
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

    public function vehiclesArchives(Request $request)
    {
        return Excel::download(new VehiclesArchivesExport($request), 'VehiclesArchives.xlsx');
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

    public function washings()
    {
        return Excel::download(new VehicleWashingExport(), 'lavados.xlsx');
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
            // Desactivar el límite de tiempo de ejecución para exportaciones grandes
            set_time_limit(-1);
            
            $file = fopen('php://output', 'w');
            // Agregar BOM UTF-8 para Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['ID', 'Fecha apertura', 'Matricula', 'Chasis', 'Equipo', 'Taller', 'Estado', 'Nota', 'Operaciones realizadas', 'Recambios', 'Operario asignado', 'Conductor incidencia asociada', 'Horas de reparación', 'Coste de reparación', 'Coste de recambio', 'Coste total'], ';');

            $orders = RepairOrder::filter($request->toArray())->allowForUser()->with(['operations', 'parts'])->cursor();
            $exportService = new RepairOrderExportService();
            
            foreach ($orders as $order) {
                $row = $exportService->buildOrderRow($order);
                fputcsv($file, $row, ';');
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

    public function expense(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID Vehículo', 'Fecha', 'Vehículo', 'Concepto', 'Importe', 'Centro'], ';');

            $expenses = AdditionalVehicleExpense::filter($request->toArray())->allowForUser()->get();
            foreach ($expenses as $expense) {
                fputcsv($file, [$expense->vehicle?->id, Carbon::parse($expense->date)->format('d/m/Y'), $expense->vehicle?->plate, $expense->description, $expense->amount, $expense->customer?->name], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'carga de gastos.csv', $this->getHeaders());
    }

    public function additionalVehicleExpenses(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID Vehículo', 'Fecha', 'Vehículo', 'Concepto', 'Proveedor', 'Cantidad', 'Precio unitario', 'Importe', 'Centro'], ';');

            $expenses = AdditionalVehicleExpense::filter($request->toArray())->allowForUser()->get();
            foreach ($expenses as $expense) {
                fputcsv($file, [$expense->vehicle?->id, Carbon::parse($expense->date)->format('d/m/Y'), $expense->vehicle?->plate, $expense->description, $expense->supplier, $expense->quantity, $expense->unit_price, $expense->amount, $expense->customer?->name], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'gastos.csv', $this->getHeaders());
    }

    public function spareParts(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Marca', 'Referencia', 'Descripción', 'Precio', 'Stock', 'Centro', 'Stock de seguridad'], ';');

            $spare_parts = SparePart::filter($request->toArray())->allowForUser()->get();
            foreach ($spare_parts as $spare_part) {
                fputcsv($file, [$spare_part->manufacturer, $spare_part->reference, $spare_part->description, $spare_part->unit_price, $spare_part->stock, $spare_part->customer->name ?? 'Sin asignar', $spare_part->safety_stock], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'recambios.csv', $this->getHeaders());
    }

    public function incidents(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['ID', 'Matrícula', 'Incidencia', 'Operario asignado', 'Fecha apertura', 'Fecha cierre'], ';');

            $incidents = VehicleIncident::filter($request->toArray())
                ->whereNull('closed_at')
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })->get();

            foreach ($incidents as $incident) {
                fputcsv($file, [
                    $incident->id,
                    $incident->vehicle?->plate,
                    $incident->incidence,
                    $incident->user?->name,
                    Carbon::parse($incident->created_at)->format('d/m/Y H:i'),
                    $incident->closed_at ? Carbon::parse($incident->closed_at)->format('d/m/Y H:i') : '',
                ], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'incidencias.csv', $this->getHeaders());
    }

    public function guarantees(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['ID', 'Matrícula', 'Garantía', 'Operario asignado', 'Fecha apertura', 'Fecha cierre'], ';');

            $guarantees = VehicleGuarantee::filter($request->toArray())
                ->whereNull('closed_at')
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })
                ->with(['vehicle', 'user'])
                ->latest()
                ->get();

            foreach ($guarantees as $guarantee) {
                fputcsv($file, [
                    $guarantee->id,
                    $guarantee->vehicle?->plate,
                    $guarantee->guarantee,
                    $guarantee->user?->name,
                    Carbon::parse($guarantee->created_at)->format('d/m/Y H:i'),
                    $guarantee->closed_at ? Carbon::parse($guarantee->closed_at)->format('d/m/Y H:i') : '',
                ], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'garantias.csv', $this->getHeaders());
    }

    public function containers(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Referencia', 'Fabricante', 'Modelo', 'Estado', 'Cliente', 'Ubicación', 'Propietario'], ';');

            $containers = Container::filter($request->toArray())
                ->where('fleet_id', Auth::user()->fleet->id)
                ->get();

            foreach ($containers as $container) {
                fputcsv($file, [
                    $container->reference,
                    $container->maker,
                    $container->model,
                    $container->state?->name ?? '',
                    $container->customer?->name ?? '',
                    $container->location ?? '',
                    $container->owner ?? '',
                ], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'contenedores.csv', $this->getHeaders());
    }

    public function users(Request $request)
    {
        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Nombre', 'Usuario', 'Email', 'Puesto', 'Activo', 'Solo lectura', 'Teléfono'], ';');

            $users = User::filter($request->toArray())
                ->where('role', 'fleet')
                ->where('entity_relation_id', Auth::user()->fleet->id)
                ->get();

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->username,
                    $user->email,
                    $user->job ?? '',
                    $user->is_active ? 'Sí' : 'No',
                    $user->is_readonly ? 'Sí' : 'No',
                    $user->phone ?? '',
                ], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'usuarios.csv', $this->getHeaders());
    }

    public function enterpriseGroups()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Nombre', 'Email', 'Contacto', 'Teléfono', 'Dirección'], ';');

            $enterpriseGroups = EnterpriseGroup::where('fleet_id', Auth::user()->fleet->id)->get();

            foreach ($enterpriseGroups as $group) {
                fputcsv($file, [
                    $group->name,
                    $group->email ?? '',
                    $group->contact ?? '',
                    $group->phone ?? '',
                    $group->address ?? '',
                ], ';');
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'grupos-empresa.csv', $this->getHeaders());
    }

    private function getHeaders()
    {
        return [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    }


}
