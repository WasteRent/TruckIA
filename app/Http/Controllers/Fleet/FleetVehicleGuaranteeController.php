<?php

namespace App\Http\Controllers\Fleet;

use App\Events\GuaranteeClosed;
use App\Events\GuaranteeOpened;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleGuarantee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetVehicleGuaranteeController extends Controller
{
    public function index(Request $request, Vehicle $vehicle)
    {
        $guarantees = VehicleGuarantee::filter($request->toArray())->whereHas('vehicle', function ($q) use ($vehicle) {
            $q->where('id', $vehicle->id);
        })->latest()->get();

        return view('fleet.vehicles.guarantees.index', [
            'vehicle' => $vehicle,
            'guarantees' => $guarantees,
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $guarantee = new VehicleGuarantee($request->all());
        $guarantee->user_id = Auth::user()->id;
        $vehicle->guarantees()->save($guarantee);

        event(new GuaranteeOpened($guarantee));

        return back()->with('success_message', 'Garantía añadida');
    }

    public function update(Request $request, Vehicle $vehicle, int $guarantee_id)
    {
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

    public function destroy(Vehicle $vehicle, int $guarantee_id)
    {
        VehicleGuarantee::findOrFail($guarantee_id)->delete();

        return back()->with('success_message', 'Garantía eliminada');
    }
}
