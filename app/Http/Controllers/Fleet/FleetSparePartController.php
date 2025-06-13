<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SparePartRequest;
use App\Models\Customer;
use App\Models\MaintenancePlan;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\SparePart;
use Illuminate\Http\Request;

class FleetSparePartController extends Controller
{
    public function index(Request $request)
    {
        $filters = SparePart::filters($request->all());
        $spare_parts = SparePart::where($filters)->where('fleet_id', auth()->user()->fleet->id)->paginate();

        return view('fleet.spare_parts.index', [
            'spare_parts' => $spare_parts,
            'allowed_customers' => auth()->user()->allowedCustomers->isEmpty() ? Customer::where('fleet_id', auth()->user()->fleet->id)->orderBy('name')->get() : auth()->user()->allowedCustomers,
        ]);
    }

    public function create()
    {
        return view('fleet.spare_parts.create', [
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all(),
            'plans' => MaintenancePlan::all(),
        ]);
    }

    public function store(SparePartRequest $request)
    {
        $spare_part = new SparePart(
            array_merge($request->all(), ['short_reference' => Helpers::shortReference($request->reference)])
        );
        $spare_part->fleet_id = auth()->user()->fleet->id;
        $spare_part->save();

        return redirect()->route('fleet.spare-parts.index')->with('success_message', 'Recambio creado');
    }

    public function show(SparePart $spare_part)
    {
        return view('fleet.spare_parts.show', [
            'spare_part' => $spare_part,
        ]);
    }

    public function edit(SparePart $spare_part)
    {
        return view('fleet.spare_parts.edit', [
            'spare_part' => $spare_part,
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all(),
            'plans' => MaintenancePlan::all(),
        ]);
    }

    public function update(SparePartRequest $request, SparePart $spare_part)
    {
        $spare_part->update(
            array_merge($request->all(), ['short_reference' => Helpers::shortReference($request->reference)])
        );

        return redirect()->route('fleet.spare-parts.index')->with('success_message', 'Recambio actualizado');
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

    public function search(Request $request)
    {
        return SparePart::where('short_reference', Helpers::shortReference($request->term ?? ''))->where('fleet_id', auth()->user()->fleet->id)->first();
    }
}
