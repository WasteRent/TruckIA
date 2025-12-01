<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\Checklist;
use App\Models\ContainerChecklist;
use App\Models\ContainerChecklistItem;
use Illuminate\Http\Request;

class FleetContainerChecklistController extends Controller
{
    public function index(Request $request, Container $container)
    {
        $containerChecklists = ContainerChecklist::filter($request->all())
            ->where('container_id', $container->id)
            ->latest()
            ->get();

        return view('fleet.containers.checklist.index', [
            'container' => $container,
            'checklists' => Checklist::all(),
            'containerChecklists' => $containerChecklists,
            'active_checklists' => true,
        ]);
    }

    public function store(Request $request, Container $container)
    {
        $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
            'date' => 'required|date',
        ]);

        $checklist = Checklist::find($request->checklist_id);
        $container_checklist = ContainerChecklist::create([
            'container_id' => $container->id,
            'checklist_id' => $checklist->id,
            'date' => $request->date,
        ]);

        foreach ($checklist->items as $item) {
            ContainerChecklistItem::create([
                'container_checklist_id' => $container_checklist->id,
                'checklist_item_id' => $item->id,
                'is_checked' => false,
            ]);
        }

        return redirect()->route('fleet.container-checklists.edit', $container_checklist)
            ->with('success_message', 'Checklist creada correctamente');
    }
}
