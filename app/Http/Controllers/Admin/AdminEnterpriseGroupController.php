<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EnterpriseGroupRequest;
use App\Models\EnterpriseGroup;

class AdminEnterpriseGroupController extends Controller
{

    public function index()
    {
        return view('admin.enterprise_groups.index', [
            'enterprises' => EnterpriseGroup::all()
        ]);
    }

    public function create()
    {
        return view('admin.enterprise_groups.create');
    }

    public function store(EnterpriseGroupRequest $request)
    {
        $enterprise = new EnterpriseGroup($request->all());
        $enterprise->save();

        return redirect()->route('admin.enterprise-groups.index')->with('success_message', 'Empresa creada');
    }


    public function edit(EnterpriseGroup $enterpriseGroup)
    {
        return view('admin.enterprise_groups.edit', [
            'enterprise' => $enterpriseGroup
        ]);
    }

    public function update(EnterpriseGroupRequest $request, EnterpriseGroup $enterpriseGroup)
    {
        $enterpriseGroup->update($request->all());
        return redirect()->route('admin.enterprise-groups.index')->with('success_message', 'Empresa actualizada');
    }

    public function destroy(EnterpriseGroup $enterpriseGroup)
    {
        $enterpriseGroup->delete();
        return back()->with('success_message', 'Empresa eliminada');
    }
}
