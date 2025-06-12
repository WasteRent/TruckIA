<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Imports\SparePartsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FleetImportSparePartController extends Controller
{
    public function create()
    {
        return view('fleet.spare_parts.import.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:xlsx,txt',
        ]);

        try {

            DB::beginTransaction();
            
            Excel::import(new SparePartsImport(auth()->user()->fleet->id), $request->file('attachment'));
            
            DB::commit();
            return redirect()->route('fleet.spare-parts.index')->with('success_message', 'Recambios importados correctamente');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('fleet.spare-parts.index')->with('error_message', 'Error al importar recambios');
        }
    
    }
}
