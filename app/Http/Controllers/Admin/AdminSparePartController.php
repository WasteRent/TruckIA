<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SparePartRequest;
use App\Models\MaintenancePlan;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\SparePart;
use Illuminate\Http\Request;

class AdminSparePartController extends Controller
{
    public function index(Request $request)
    {
        $filters = SparePart::filters($request->all());
        $spare_parts = SparePart::where($filters)->paginate();

        return view('admin.spare_parts.index', [
            'spare_parts' => $spare_parts
        ]);
    }

    public function create()
    {
        return view('admin.spare_parts.create', [
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all(),
            'plans' => MaintenancePlan::all()
        ]);
    }

    public function store(SparePartRequest $request)
    {
        $spare_part = new SparePart(
            array_merge($request->all(), ['short_reference' => Helpers::shortReference($request->reference)])
        );
        $spare_part->save();
        return redirect()->route('admin.spare-parts.index')->with('success_message', 'Recambio creado');
    }

    public function show(SparePart $spare_part)
    {
        return view('admin.spare_parts.show', [
            'spare_part' => $spare_part
        ]);
    }

    public function edit(SparePart $spare_part)
    {
        return view('admin.spare_parts.edit', [
            'spare_part' => $spare_part,
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all(),
            'plans' => MaintenancePlan::all()
        ]);
    }

    public function update(SparePartRequest $request, SparePart $spare_part)
    {
        $spare_part->update(
            array_merge($request->all(), ['short_reference' => Helpers::shortReference($request->reference)])
        );

        return redirect()->route('admin.spare-parts.index')->with('success_message', 'Recambio actualizado');
    }

    public function destroy(SparePart $spare_part)
    {
        try {
            $spare_part->delete();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Este recambio está asociado a operaciones.');
        }
        
        return back()->with('success_message', 'Recambio eliminado');
    }
}
