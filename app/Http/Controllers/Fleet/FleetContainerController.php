<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Container;
use App\Models\ContainerChecklist;
use App\Models\ContainerChecklistItem;
use App\Models\Customer;
use App\Models\VehicleState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetContainerController extends Controller
{
    public function index(Request $request)
    {
        $containers = Container::filter($request->all())
            ->where('fleet_id', Auth::user()->fleet->id)
            ->latest()
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
            'type' => 'nullable|in:resto,organic,cardboard,plastic,glass',
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
            'type' => 'nullable|in:resto,organic,cardboard,plastic,glass',
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

    /**
     * Buscar contenedor por referencia (para lector RFID)
     */
    public function findByReference(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
        ]);

        $container = Container::where('fleet_id', Auth::user()->fleet->id)
            ->where('reference', $request->reference)
            ->first();

        if ($container) {
            // Obtener nombres de los checklists
            $preventiveChecklist = Checklist::find(Checklist::PREVENTIVE);
            $correctiveChecklist = Checklist::find(Checklist::CORRECTIVE);

            return response()->json([
                'found' => true,
                'container' => [
                    'id' => $container->id,
                    'reference' => $container->reference,
                    'maker' => $container->maker,
                    'model' => $container->model,
                    'state' => optional($container->state)->name,
                    'location' => $container->location,
                    'customer' => optional($container->customer)->name,
                    'edit_url' => route('fleet.containers.edit', $container),
                    'checklists_url' => route('fleet.containers.checklists.index', $container),
                    'preventive_checklist' => $preventiveChecklist ? [
                        'id' => $preventiveChecklist->id,
                        'name' => $preventiveChecklist->name,
                    ] : null,
                    'corrective_checklist' => $correctiveChecklist ? [
                        'id' => $correctiveChecklist->id,
                        'name' => $correctiveChecklist->name,
                    ] : null,
                ],
            ]);
        }

        return response()->json([
            'found' => false,
            'reference' => $request->reference,
            'create_url' => route('fleet.containers.create', ['reference' => $request->reference]),
        ]);
    }

    /**
     * Crear checklist rápido desde RFID
     */
    public function quickChecklist(Request $request, Container $container)
    {
        $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
        ]);

        $checklist = Checklist::find($request->checklist_id);

        $containerChecklist = ContainerChecklist::create([
            'container_id' => $container->id,
            'checklist_id' => $checklist->id,
            'date' => now()->format('Y-m-d'),
        ]);

        foreach ($checklist->items as $item) {
            ContainerChecklistItem::create([
                'container_checklist_id' => $containerChecklist->id,
                'checklist_item_id' => $item->id,
                'is_checked' => false,
            ]);
        }

        return redirect()->route('fleet.container-checklists.edit', $containerChecklist)
            ->with('success_message', 'Checklist creado correctamente');
    }
}
