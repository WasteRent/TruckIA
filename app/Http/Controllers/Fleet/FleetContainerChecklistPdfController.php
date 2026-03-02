<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\PdfGeneratorV2;
use App\Http\Controllers\Controller;
use App\Mail\ContainerChecklistPdfMail;
use App\Models\Container;
use App\Models\ContainerChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FleetContainerChecklistPdfController extends Controller
{
    public function sendSingle(Request $request, ContainerChecklist $container_checklist)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $container_checklist->load(['items.checklistItem', 'workLines', 'container.createdBy']);

        $html = view('fleet.containers.checklist.pdf', [
            'container_checklist' => $container_checklist,
        ])->render();

        $pdf = (new PdfGeneratorV2)->generate($html);

        Mail::send(new ContainerChecklistPdfMail($container_checklist, $request->email, $pdf));

        return back()->with('success_message', __('Checklist enviado por correo correctamente'));
    }

    public function sendRange(Request $request, Container $container)
    {
        $request->validate([
            'email' => 'required|email',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        $container_checklists = ContainerChecklist::query()
            ->where('container_id', $container->id)
            ->when($request->date_from, function ($query) use ($request) {
                $query->whereDate('date', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($query) use ($request) {
                $query->whereDate('date', '<=', $request->date_to);
            })
            ->orderBy('date')
            ->get();

        if ($container_checklists->isEmpty()) {
            return back()->with('error_message', __('No hay checklists en el rango de fechas seleccionado'));
        }

        $container_checklists->load(['items.checklistItem', 'workLines', 'container.createdBy']);

        $html = view('fleet.containers.checklist.pdf_range', [
            'container_checklists' => $container_checklists,
        ])->render();

        $pdf = (new PdfGeneratorV2)->generate($html);

        $first_checklist = $container_checklists->first();

        Mail::send(new ContainerChecklistPdfMail($first_checklist, $request->email, $pdf));

        return back()->with('success_message', __('Checklists enviadas por correo correctamente'));
    }
}

