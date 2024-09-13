<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\AlertService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AccidentReportRequest;
use App\Models\AccidentReport;
use App\Models\AlertType;
use App\Models\File;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FleetVehicleAccidentReportController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.accidents.index', [
            'vehicle' => $vehicle,
            'accident_reports' => $vehicle->accident_reports
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        return view('fleet.vehicles.accidents.create', [
            'vehicle' => $vehicle,
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'summary' => 'required',
            'created_at' => 'required|date',
        ]);

        $report = AccidentReport::create([
            'summary' => $request->summary,
            'vehicle_id' => $vehicle->id,
            'user_id' => auth()->user()->id,
        ]);

        (new AlertService)->to($vehicle->fleet)->forVehicle($vehicle)->notify(
            'Nuevo accidente reportado',
            $report->summary,
            "/fleet/vehicles/{$vehicle->id}",
            AlertType::ACCIDENT
        );

        return redirect()->route('fleet.vehicles.accident-reports.index', $vehicle)->with('success_message', 'Siniestro reportado');
    }

    public function destroy(Vehicle $vehicle, AccidentReport $accidentReport)
    {
        $accidentReport->delete();

        return redirect()->route('fleet.vehicles.accident-reports.index', $vehicle)->with('success_message', 'Siniestro eliminado');
    }
}
