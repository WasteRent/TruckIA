<?php

namespace App\Http\Controllers\Fleet;

use App\Events\GuaranteeClosed;
use App\Http\Controllers\Controller;
use App\Events\GuaranteeOpened;
use App\Models\VehicleGuarantee;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetGuaranteeController extends Controller
{
    public function index(Request $request)
    {
        $guarantees = VehicleGuarantee::filter($request->toArray())
                ->whereNull('closed_at')
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })->latest()->paginate(20);

        if (Auth::user()->job == 'driver') {
            $guarantees = collect([]);
        }

        return view('fleet.guarantees.index', [
            'guarantees' => $guarantees,
        ]);
    }

    public function create() {
        return view('fleet.guarantees.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'guarantee' => 'required',
            'created_at' => 'required',
            'plate' => 'required',
        ]);

        $vehicle = Vehicle::where('plate', $data['plate'])
                        ->where('fleet_id', Auth::user()->fleet->id)
                        ->first();

        if ($vehicle) {
            $guarantee = VehicleGuarantee::create([
                'user_id' => Auth::user()->id,
                'guarantee' => $data['guarantee'],
                'created_at' => $data['created_at'],
                'vehicle_id' => $vehicle->id
            ]);

            event(new GuaranteeOpened($guarantee));

            return to_route('fleet.guarantees.index')->with('success_message', 'Garantía añadida. ID: #' . $guarantee->id);
        } else {
            return back()->with('error_message', 'Matricula no encontrada');
        }
    }
    
    public function update(Request $request, int $guarantee_id) {

        if (isset($request["guarantee_{$guarantee_id}"])) {
            VehicleGuarantee::findOrFail($guarantee_id)->update([
                'guarantee' => $request["guarantee_{$guarantee_id}"],
            ]);
        }
        if (isset($request["guarantee_date_{$guarantee_id}"])) {
            VehicleGuarantee::findOrFail($guarantee_id)->update([
                'created_at' => $request["guarantee_date_{$guarantee_id}"],
            ]);
        }
        if (isset($request["mechanic_user_id_{$guarantee_id}"]) && ! empty($request["mechanic_user_id_{$guarantee_id}"])) {
            VehicleGuarantee::findOrFail($guarantee_id)->update([
                'user_id' => $request["mechanic_user_id_{$guarantee_id}"],
            ]);
        }
        if (isset($request['closed_at'])) {
            VehicleGuarantee::findOrFail($guarantee_id)->update([
                'closed_at' => now(),
            ]);
            event(new GuaranteeClosed(VehicleGuarantee::findOrFail($guarantee_id)));
        }
        if (isset($request['reopen'])) {
            VehicleGuarantee::findOrFail($guarantee_id)->update([
                'closed_at' => null,
            ]);
            event(new GuaranteeOpened(VehicleGuarantee::findOrFail($guarantee_id)));
        }

        return back()->with('success_message', 'Garantía actualizada');
    }

}
