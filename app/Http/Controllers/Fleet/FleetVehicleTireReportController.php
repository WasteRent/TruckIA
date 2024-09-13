<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\AlertService;
use App\Http\Controllers\Controller;
use App\Models\TireReport;
use App\Models\AlertType;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FleetVehicleTireReportController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.tires.index', [
            'vehicle' => $vehicle,
            'tires_reports' => $vehicle->tires_reports
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        return view('fleet.vehicles.tires.create', [
            'vehicle' => $vehicle,
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'summary' => 'required',
            'created_at' => 'required|date',
        ]);

        $report = TireReport::create([
            'summary' => $request->summary,
            'vehicle_id' => $vehicle->id,
            'user_id' => auth()->user()->id,
        ]);


        return redirect()->route('fleet.vehicles.tires-reports.index', $vehicle)->with('success_message', 'Reporte de neumáticos reportado');
    }

    public function destroy(Vehicle $vehicle, TireReport $tireReport)
    {
        $tireReport->delete();

        return redirect()->route('fleet.vehicles.tires-reports.index', $vehicle)->with('success_message', 'Neumáticos eliminado');
    }
}
