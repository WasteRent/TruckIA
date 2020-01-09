<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OperationSubfamilyRequest;
use App\Models\OperationFamily;
use App\Models\OperationSubfamily;

class AdminSubfamilyController extends Controller
{

    public function index(OperationFamily $family)
    {
        return view('admin.families.subfamilies.index', [
            'family' => $family,
            'subfamilies' => $family->subfamilies
        ]);
    }

    public function create(OperationFamily $family)
    {
        return view('admin.families.subfamilies.create', [
            'family' => $family
        ]);
    }

    public function store(OperationSubfamilyRequest $request, OperationFamily $family)
    {
        $subfamily = new OperationSubfamily($request->all());
        $family->subfamilies()->save($subfamily);
        return redirect()->route('admin.families.subfamilies.index', $family)->with('success_message', 'Subfamilia creada');
    }


    public function edit(OperationFamily $family, OperationSubfamily $subfamily)
    {
        return view('admin.families.subfamilies.edit', [
            'family' => $family,
            'subfamily' => $subfamily
        ]);
    }

    public function update(OperationSubfamilyRequest $request, OperationFamily $family, OperationSubfamily $subfamily)
    {
        $subfamily->update($request->all());
        return redirect()->route('admin.families.subfamilies.index', $family)->with('success_message', 'Subfamilia actualizada');
    }

    public function destroy(OperationSubfamily $family)
    {
        //
    }
}
