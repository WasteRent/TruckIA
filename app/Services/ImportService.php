<?php

namespace App\Services;

use App\Imports\ImportAdditionalVehicleExpenses;
use App\Imports\ImportAdditionalVehicleExpensesUteRmVao;
use App\Imports\ImportAdditionalVehicleExpensesVision;
use App\Imports\ImportAdditionalVehicleExpensesCentroGalicia;
use App\Jobs\ProcessAdditionalVehicleExpenses;
use App\Jobs\ProcessAdditionalVehicleExpensesCentroGalicia;
use App\Jobs\ProcessAdditionalVehicleExpensesUteRmVao;
use App\Jobs\ProcessAdditionalVehicleExpensesVision;
use Illuminate\Http\UploadedFile;

use Maatwebsite\Excel\Facades\Excel;

class ImportService
{

    public function __construct(private int $fleet_id, private string $type) {}

    public function import(UploadedFile $file)
    {
        return match ($this->type) {
            'ZONA_SUR' => $this->importAdditionalVehicleExpenses($this->fleet_id, $file),
            'UTE_RM_VAO' => $this->importAdditionalVehicleExpensesUteRmVao($this->fleet_id, $file),
            'VISION' => $this->importAdditionalVehicleExpensesVision($this->fleet_id, $file),
            'ZONA_CENTRO_GALICIA' => $this->importAdditionalVehicleExpensesCentroGalicia($this->fleet_id, $file),
            default => '',
        };
    }

    public function importAdditionalVehicleExpenses($fleetId, $file)
    {
        try {
            $collections = Excel::toCollection(new ImportAdditionalVehicleExpenses($fleetId), $file);
            $rows = $collections->first();

            ProcessAdditionalVehicleExpenses::dispatch($rows, $fleetId);

            return redirect()->back()->with('success', 'Se está procesando el archivo. Puede tardar unos minutos en completarse.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error al importar el archivo');
        }
    }

    public function importAdditionalVehicleExpensesUteRmVao($fleetId, $file)
    {
        try {
            $collections = Excel::toCollection(new ImportAdditionalVehicleExpensesUteRmVao($fleetId), $file);
            $rows = $collections->first();

            ProcessAdditionalVehicleExpensesUteRmVao::dispatch($rows, $fleetId);

            return redirect()->back()->with('success', 'Se está procesando el archivo. Puede tardar unos minutos en completarse.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error al importar el archivo');
        }
    }

    public function importAdditionalVehicleExpensesVision($fleetId, $file)
    {
        try {
            $collections = Excel::toCollection(new ImportAdditionalVehicleExpensesVision($fleetId), $file);
            $rows = $collections->first();

            ProcessAdditionalVehicleExpensesVision::dispatch($rows, $fleetId);

            return redirect()->back()->with('success', 'Se está procesando el archivo. Puede tardar unos minutos en completarse.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error al importar el archivo');
        }
    }

    public function importAdditionalVehicleExpensesCentroGalicia($fleetId, $file)
    {
        try {
            $collections = Excel::toCollection(new ImportAdditionalVehicleExpensesCentroGalicia($fleetId), $file);
            $rows = $collections->first();

            ProcessAdditionalVehicleExpensesCentroGalicia::dispatch($rows, $fleetId);

            return redirect()->back()->with('success', 'Se está procesando el archivo. Puede tardar unos minutos en completarse.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error al importar el archivo');
        }
    }
}
