<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Events\GuaranteeOpened;
use App\Models\Guarantee;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetGuaranteeController extends Controller
{
    public function index(Request $request)
    {
        return view('fleet.guarantees.index', [
            'guarantees' => Guarantee::filter($request->all())->whereHas('vehicle', function ($q) {
                $q->allowForUser();
            })->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('fleet.guarantees.create');
    }

    public function store(Request $request, Guarantee $guarantee)
    {
        $data = $request->validate([
            'description' => 'required',
            'plate' => 'required',
        ]);
        
        
        $vehicle = Vehicle::where('plate', $data['plate'])->where('fleet_id', Auth::user()->fleet->id)->first();

        if ($vehicle) {
            $guarantee = Guarantee::create([
                'creator_user_id' => Auth::user()->id,
                'description' => $data['description'],
                'vehicle_id' => $vehicle->id
            ]);

            /* event(new GuaranteeOpened($guarantee)); */

            return redirect()->route('fleet.guarantees.index')->with('success_message', 'Garantía añadida. ID: #' . $guarantee->id);
        } else {
            return back()->with('error_message', 'Matricula no encontrada');
        }
    }

    public function update(Request $request, int $guarantee_id) {

        return back()->with('success_message', 'Garantía actualizada');
    }
    
    public function destroy(Guarantee $guarantee)
    {
        $guarantee->delete();

        return back()->with('success_message', 'Garantía eliminada');
    }
}
