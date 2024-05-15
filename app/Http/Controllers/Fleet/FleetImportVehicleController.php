<?php

namespace App\Http\Controllers\Fleet;

use App\Imports\FleetVehicleImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class FleetImportVehicleController extends Controller
{
    public function create()
    {
        return view('fleet.vehicles.import.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:xlsx,txt',
        ]);

        DB::beginTransaction();

        try {
            Excel::import(new FleetVehicleImport, $request->file('attachment'));

            DB::commit();

            return redirect()->route('fleet.vehicles.index')->with('success_message', 'Los vehículos y equipamientos se han importado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('fleet.vehicles.index')->with('error_message', 'Hubo un problema al importar los datos: ' . $e->getMessage());
        }
    }
}
