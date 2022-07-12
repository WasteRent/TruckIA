<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UniversalOperationRequest;
use App\Models\File;
use App\Models\OperationFamily;
use App\Models\OperationSubfamily;
use App\Models\UniversalOperation;
use Illuminate\Http\Request;

class AdminUniversalOperationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->all()) {
            session(['filters' => $request->all()]);
        }

        $filters = UniversalOperation::filters(session('filters') ?? []);
        $operations = UniversalOperation::where($filters)->paginate();

        return view('admin.universal_operations.index', [
            'operations' => $operations,
        ]);
    }

    public function create()
    {
        return view('admin.universal_operations.create', [
            'families' => OperationFamily::all(),
            'subfamilies' => OperationSubfamily::where('family_id', session('_old_input')['family_id'] ?? ['']),
        ]);
    }

    public function store(UniversalOperationRequest $request)
    {
        $operation = new UniversalOperation($request->toArray());

        if ($request->attachment) {
            $file = File::storeFile($request->attachment);
            $operation->attachment_file_id = $file->id;
        }

        $operation->save();

        return redirect()->route('admin.universal-operations.index')
            ->with('success_message', 'Operación añadida');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UniversalOperation  $universalOperation
     * @return \Illuminate\Http\Response
     */
    public function edit(UniversalOperation $universalOperation)
    {
        return view('admin.universal_operations.edit', [
            'operation' => $universalOperation,
            'families' => OperationFamily::all(),
            'subfamilies' => OperationSubfamily::where('family_id', $universalOperation->subfamily->family->id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UniversalOperation  $universalOperation
     * @return \Illuminate\Http\Response
     */
    public function update(UniversalOperationRequest $request, UniversalOperation $universalOperation)
    {
        $universalOperation->update($request->toArray());

        if ($request->attachment) {
            $file = File::storeFile($request->attachment);
            $universalOperation->attachment_file_id = $file->id;
            $universalOperation->save();
        }

        return redirect()->route('admin.universal-operations.index')
            ->with('success_message', 'Operación Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UniversalOperation  $universalOperation
     * @return \Illuminate\Http\Response
     */
    public function destroy(UniversalOperation $universalOperation)
    {
        $universalOperation->delete();

        return back()->with('success_message', 'Operación eliminada');
    }
}
