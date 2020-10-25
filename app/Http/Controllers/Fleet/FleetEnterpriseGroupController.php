<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\EnterpriseGroupRequest;
use App\Models\EnterpriseGroup;
use Illuminate\Support\Facades\Auth;

class FleetEnterpriseGroupController extends Controller
{

    public function index()
    {
        return view('fleet.enterprise_groups.index', [
            'enterprises' => EnterpriseGroup::where('fleet_id', Auth::user()->fleet->id)->get()
        ]);
    }

    public function create()
    {
        return view('fleet.enterprise_groups.create');
    }

    public function store(EnterpriseGroupRequest $request)
    {
        $enterprise = new EnterpriseGroup($request->all());
        $enterprise->fleet_id = Auth::user()->fleet->id;
        $enterprise->save();

        return redirect()->route('fleet.enterprise-groups.index')->with('success_message', 'Empresa creada');
    }


    public function edit(EnterpriseGroup $enterpriseGroup)
    {
        return view('fleet.enterprise_groups.edit', [
            'enterprise' => $enterpriseGroup
        ]);
    }

    public function update(EnterpriseGroupRequest $request, EnterpriseGroup $enterpriseGroup)
    {
        $enterpriseGroup->update($request->all());
        return redirect()->route('fleet.enterprise-groups.index')->with('success_message', 'Empresa actualizada');
    }

    public function destroy(EnterpriseGroup $enterpriseGroup)
    {
        if ($enterpriseGroup->customers->isNotEmpty()) {
            return back()->with('error_message', "Este grupo tiene asignado los clientes: {$enterpriseGroup->customers->pluck('name')->join(', ')}");
        }

        $enterpriseGroup->delete();

        return back()->with('success_message', 'Empresa eliminada');
    }
}
