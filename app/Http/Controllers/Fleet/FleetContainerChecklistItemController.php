<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Mail\ContainerChecklistPdfMail;
use App\Models\ContainerChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;

class FleetContainerChecklistItemController extends Controller
{
    public function edit(ContainerChecklist $container_checklist)
    {
        $container_checklist->load(['workLines', 'container.createdBy']);

        return view('fleet.containers.checklist.edit', [
            'container_checklist' => $container_checklist,
            'container' => $container_checklist->container,
            'active_checklists' => true,
        ]);
    }

    public function update(Request $request, ContainerChecklist $container_checklist)
    {
        $checked_items = $request->items ?? [];
        
        foreach ($container_checklist->items as $item) {
            $item->is_checked = isset($checked_items[$item->id]);
            $item->save();
        }

        $container_checklist->update([
            'observations' => $request->observations,
        ]);

        return back()->with('success_message', 'Checklist actualizada');
    }

    public function destroy(ContainerChecklist $container_checklist)
    {
        $container_checklist->items()->delete();
        $container_checklist->delete();

        return back()->with('success_message', 'Checklist eliminada');
    }

    public function sendPdf(Request $request, ContainerChecklist $container_checklist)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $container_checklist->load(['items.checklistItem', 'workLines', 'container.createdBy']);

        $html = view('fleet.containers.checklist.pdf', [
            'container_checklist' => $container_checklist,
        ])->render();
        
        $pdf = Browsershot::html($html)->setChromePath('/usr/bin/chromium-browser')->showBackground()->pdf();

        Mail::send(new ContainerChecklistPdfMail($container_checklist, $request->email, $pdf));

        return back()->with('success_message', __('Checklist enviado por correo correctamente'));
    }
}
