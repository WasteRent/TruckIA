<?php

namespace App\Services;

use App\Imports\ImportAdditionalVehicleExpenses;
use App\Imports\ImportAdditionalVehicleExpensesUteRmVao;
use App\Imports\ImportAdditionalVehicleExpensesVision;
use App\Imports\ImportAdditionalVehicleExpensesZonaSur;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ImportService
{

    public function __construct(private int $fleet_id, private int $customer_id, private string $type)
    {
    }

    public function import(UploadedFile $file)
    {
        return match ($this->type) {
            'ZONA_CENTRO_GALICIA' => $this->importAdditionalVehicleExpenses($this->fleet_id, $this->customer_id, $file),
            'UTE_RM_VAO' => $this->importAdditionalVehicleExpensesUteRmVao($this->fleet_id, $this->customer_id, $file),
            'VISION' => $this->importAdditionalVehicleExpensesVision($this->fleet_id, $this->customer_id, $file),
            'ZONA_SUR' => $this->importAdditionalVehicleExpensesZonaSur($this->fleet_id, $this->customer_id, $file),
            default => '',
        };
    }

    public function importAdditionalVehicleExpenses($fleetId, $customerId, $file)
    {
        return Excel::import(
            new ImportAdditionalVehicleExpenses($fleetId, $customerId), 
            $file
        );
    }

    public function importAdditionalVehicleExpensesUteRmVao($fleetId, $customerId, $file)
    {
        return Excel::import(
            new ImportAdditionalVehicleExpensesUteRmVao($fleetId, $customerId), 
            $file
        );
    }

    public function importAdditionalVehicleExpensesVision($fleetId, $customerId, $file)
    {
        return Excel::import(
            new ImportAdditionalVehicleExpensesVision($fleetId, $customerId), 
            $file
        );
    }

    public function importAdditionalVehicleExpensesZonaSur($fleetId, $customerId, $file)
    {
        return Excel::import(
            new ImportAdditionalVehicleExpensesZonaSur($fleetId, $customerId), 
            $file
        );
    }
}