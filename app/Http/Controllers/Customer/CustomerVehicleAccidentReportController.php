<?php

namespace App\Http\Controllers\Customer;

use App\Classes\AlertService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AccidentReportRequest;
use App\Models\AccidentReport;
use App\Models\AlertType;
use App\Models\File;
use App\Models\Fleet;
use App\Models\Vehicle;

class CustomerVehicleAccidentReportController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('customer.accident_reports.index', [
            'vehicle' => $vehicle
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        return view('customer.accident_reports.create', [
            'vehicle' => $vehicle
        ]);
    }

    public function store(AccidentReportRequest $request, Vehicle $vehicle)
    {
        $file = File::storeFile($request->file, 'accidente');

        $report = AccidentReport::create([
            'summary' => $request->summary,
            'file_id' => $file->id,
            'vehicle_id' => $vehicle->id
        ]);

        (new AlertService)->to(Fleet::first())->forVehicle($vehicle)->notify(
            'Nuevo accidente reportado',
            $report->summary,
            "/fleet/vehicles/{$vehicle->id}",
            AlertType::ACCIDENT
        );

        return redirect()->route('customer.vehicles.accident-reports.index', $vehicle)->with('success_message', 'Accidente reportado');
    }
}
