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

    public function update(Request $request, Vehicle $vehicle, $tire_report_id)
    {
        if (isset($request["tires_report_{$tire_report_id}"])) {
            TireReport::findOrFail($tire_report_id)->update([
                'summary' => $request["tires_report_{$tire_report_id}"],
            ]);
        }
        if (isset($request["tires_report_date_{$tire_report_id}"])) {
            TireReport::findOrFail($tire_report_id)->update([
                'created_at' => $request["tires_report_date_{$tire_report_id}"],
            ]);
        }
        if (isset($request['closed_at'])) {
            TireReport::findOrFail($tire_report_id)->update([
                'closed_at' => now(),
            ]);
        }
        if (isset($request['reopen'])) {
            TireReport::findOrFail($tire_report_id)->update([
                'closed_at' => null,
            ]);
        }

        return redirect()->route('fleet.vehicles.tires-reports.index', $vehicle)->with('success_message', 'Neumáticos actualizado');
    }

    public function destroy(Vehicle $vehicle, TireReport $tireReport)
    {
        $tireReport->delete();

        return redirect()->route('fleet.vehicles.tires-reports.index', $vehicle)->with('success_message', 'Neumáticos eliminado');
    }
}
