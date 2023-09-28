<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Container;
use Illuminate\Support\Facades\Auth;
use App\Models\VehicleState;
use App\Models\Customer;

class FleetContainerController extends Controller
{
    public function index(Request $request)
    {
        $containers = Container::filter($request->all())
            ->where('fleet_id', Auth::user()->fleet->id)
            ->paginate(20);

        return view('fleet.containers.index', [
            'containers' => $containers,
            'states' => VehicleState::all(),
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('fleet.containers.create', [
            'states' => VehicleState::all(),
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {   
        $data = $request->validate([
            'reference' => 'required',
            'maker' => 'nullable',
            'model' => 'nullable',
            'state_id' => 'required',
            'customer_id' => 'nullable',
            'location' => 'nullable',
            'owner' => 'nullable',
        ]);

        $container = new Container($data);
        $container->fleet_id = Auth::user()->fleet->id;
        $container->save();

        return redirect()->route('fleet.containers.edit', $container)->with('success_message', 'Contenedor actualizado');
    }

    public function edit(Container $container)
    {
        return view('fleet.containers.edit', [
            'container' => $container,
            'states' => VehicleState::all(),
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Container $container)
    {   
        $data = $request->validate([
            'reference' => 'required',
            'maker' => 'nullable',
            'model' => 'nullable',
            'state_id' => 'required',
            'customer_id' => 'nullable',
            'location' => 'nullable',
            'owner' => 'nullable',
        ]);

        $container->update($data);

        return redirect()->route('fleet.containers.edit', $container)->with('success_message', 'Contenedor actualizado');
    }

    public function destroy(Container $container)
    {
        $container->delete();
        return back()->with('success_message', 'Contenedor eliminado');
    }
}
