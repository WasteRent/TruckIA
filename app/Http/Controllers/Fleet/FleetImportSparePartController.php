<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Imports\SparePartsImport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FleetImportSparePartController extends Controller
{
    public function create()
    {
        $allowed_customers = auth()->user()->allowedCustomers->isEmpty() ? Customer::where('fleet_id', auth()->user()->fleet->id)->orderBy('name')->get() : auth()->user()->allowedCustomers;
        return view('fleet.spare_parts.import.create', ['allowed_customers' => $allowed_customers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:xlsx,txt',
            'customer_id' => 'required',
        ]);

        try {

            DB::beginTransaction();
            
            Excel::import(new SparePartsImport(auth()->user()->fleet->id, $request->customer_id), $request->file('attachment'));
            
            DB::commit();
            return redirect()->route('fleet.spare-parts.index')->with('success_message', 'Recambios importados correctamente');
        } catch (\Exception $e) {
            return redirect()->route('fleet.spare-parts.index')->with('error_message', 'Error al importar recambios');
        }
    
    }
}
