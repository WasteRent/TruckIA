<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\ContainerChecklist;
use App\Models\ContainerChecklistWorkLine;
use Illuminate\Http\Request;

class FleetContainerChecklistWorkLineController extends Controller
{
    public function store(Request $request, ContainerChecklist $container_checklist)
    {
        $request->validate([
            'line_type' => 'required|in:labor,part',
            'description' => 'required|string|max:500',
            'time_in_hours' => 'required_if:line_type,labor|nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
        ]);

        $data = [
            'container_checklist_id' => $container_checklist->id,
            'line_type' => $request->line_type,
            'description' => $request->description,
            'time_in_hours' => $request->line_type === ContainerChecklistWorkLine::TYPE_LABOR ? $request->time_in_hours : null,
            'price' => $request->line_type === ContainerChecklistWorkLine::TYPE_PART ? $request->price : null,
        ];

        ContainerChecklistWorkLine::create($data);

        return back()->with('success_message', __('Línea añadida'));
    }

    public function update(Request $request, ContainerChecklist $container_checklist, int $work_line)
    {
        $work_line = ContainerChecklistWorkLine::where('container_checklist_id', $container_checklist->id)->findOrFail($work_line);

        $rules = [
            'description' => 'required|string|max:500',
        ];

        if ($work_line->line_type === ContainerChecklistWorkLine::TYPE_LABOR) {
            $rules['time_in_hours'] = 'required|numeric|min:0';
        } else {
            $rules['price'] = 'nullable|numeric|min:0';
        }

        $request->validate($rules);

        $data = [
            'description' => $request->description,
            'time_in_hours' => $work_line->line_type === ContainerChecklistWorkLine::TYPE_LABOR ? $request->time_in_hours : null,
            'price' => $work_line->line_type === ContainerChecklistWorkLine::TYPE_PART ? $request->price : null,
        ];

        $work_line->update($data);

        return back()->with('success_message', __('Línea actualizada'));
    }

    public function destroy(ContainerChecklist $container_checklist, int $work_line)
    {
        $work_line = ContainerChecklistWorkLine::where('container_checklist_id', $container_checklist->id)
            ->findOrFail($work_line);

        $work_line->delete();

        return back()->with('success_message', __('Línea eliminada'));
    }
}
