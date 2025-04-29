<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleWashing;
use App\Models\VehicleWashingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetVehicleWashingController extends Controller
{
    public function index()
    {
        $washings = VehicleWashing::whereHas('vehicle', function ($q) {
            $q->allowForUser();
        })->latest()->paginate(10);

        return view('fleet.washing.index', [
            'washings' => $washings,
        ]);
    }

    public function create() {
        return view('fleet.washing.create', [
            'vehicle_washing_types' => VehicleWashingType::all(),
        ]);
    }


    public function show(VehicleWashing $washing) {
        
        return view('fleet.washing.show', [
            'washing' => $washing,
            'vehicle_washing_types' => VehicleWashingType::all(),
        ]);
    }

    public function store(Request $request) {

        $data = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'vehicle_id' => 'required',
        ]);

        $vehicle = Vehicle::where('id', $data['vehicle_id'])->where('fleet_id', Auth::user()->fleet->id)->first();

        if ($vehicle) {
            VehicleWashing::create([
                'user_id' => Auth::user()->id,
                'vehicle_id' => $vehicle->id,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'vehicle_id' => $vehicle->id
            ]);

            return to_route('fleet.washing.index')->with('success_message', 'Lavado añadido');
        } else {
            return back()->with('error_message', 'Matricula no encontrada');
        }
    }

    public function destroy(VehicleWashing $washing) {
        $washing->delete();
        return to_route('fleet.washing.index')->with('success_message', 'Lavado eliminado');
    }


}
